<?php

declare( strict_types = 1 );

namespace NumericId\PackagePrivate;

use NumericId\IdGenerator;
use RuntimeException;
use Wikimedia\Rdbms\IDatabase;
use Wikimedia\Rdbms\ILoadBalancer;

class SqlIdGenerator implements IdGenerator {

	/**
	 * @var ILoadBalancer
	 */
	private $loadBalancer;

	/**
	 * @var int[][]
	 */
	private $idBlacklist;

	/**
	 * @var bool whether use a separate master database connection to generate new id or not.
	 */
	private $separateDbConnection;

	/**
	 * @param ILoadBalancer $loadBalancer
	 * @param int[][] $idBlacklist
	 */
	public function __construct(
		ILoadBalancer $loadBalancer,
		array $idBlacklist = [],
		$separateDbConnection = false
	) {
		$this->loadBalancer = $loadBalancer;
		$this->idBlacklist = $idBlacklist;
		$this->separateDbConnection = $separateDbConnection;
	}

	public function getNewId( string $type = '' ): int {
		$flags = ( $this->separateDbConnection === true ) ? ILoadBalancer::CONN_TRX_AUTOCOMMIT : 0;
		$database = $this->loadBalancer->getConnection( DB_MASTER, [], false, $flags );
		$id = $this->generateNewId( $database, $type );
		$this->loadBalancer->reuseConnection( $database );

		return $id;
	}

	/**
	 * Generates and returns a new ID.
	 *
	 * @param IDatabase $database
	 * @param string $type
	 * @param bool $retry Retry once in case of e.g. race conditions. Defaults to true.
	 *
	 * @throws RuntimeException
	 * @return int
	 */
	private function generateNewId( IDatabase $database, $type, $retry = true ) {
		$database->startAtomic( __METHOD__ );

		$currentId = $database->selectRow(
			'wb_id_counters',
			'id_value',
			[ 'id_type' => $type ],
			__METHOD__,
			[ 'FOR UPDATE' ]
		);

		if ( is_object( $currentId ) ) {
			$id = $currentId->id_value + 1;
			$success = $database->update(
				'wb_id_counters',
				[ 'id_value' => $id ],
				[ 'id_type' => $type ]
			);
		} else {
			$id = 1;

			$success = $database->insert(
				'wb_id_counters',
				[
					'id_value' => $id,
					'id_type' => $type,
				]
			);

			// Retry once, since a race condition on initial insert can cause one to fail.
			// Race condition is possible due to occurrence of phantom reads is possible
			// at non serializable transaction isolation level.
			if ( !$success && $retry ) {
				$id = $this->generateNewId( $database, $type, false );
				$success = true;
			}
		}

		$database->endAtomic( __METHOD__ );

		if ( !$success ) {
			throw new RuntimeException( 'Could not generate a reliably unique ID.' );
		}

		if ( array_key_exists( $type, $this->idBlacklist ) && in_array( $id, $this->idBlacklist[$type] ) ) {
			$id = $this->generateNewId( $database, $type );
		}

		return $id;
	}

}
