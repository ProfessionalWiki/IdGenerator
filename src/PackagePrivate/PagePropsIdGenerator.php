<?php

declare( strict_types = 1 );

namespace IdGenerator\PackagePrivate;

use IdGenerator\IdGenerator;
use RuntimeException;
use Wikimedia\Rdbms\IDatabase;
use Wikimedia\Rdbms\ILoadBalancer;

class PagePropsIdGenerator implements IdGenerator {

	private const FAKE_PAGE_ID = -42;

	private $loadBalancer;

	public function __construct( ILoadBalancer $loadBalancer ) {
		$this->loadBalancer = $loadBalancer;
	}

	public function getNewId( string $type = '' ): int {
		$database = $this->loadBalancer->getConnection( DB_MASTER );

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
	private function generateNewId( IDatabase $database, string $type, $retry = true ): int {
		$database->startAtomic( __METHOD__ );

		$currentId = $database->selectRow(
			'page_props',
			'pp_value',
			$this->getWhere( $type ),
			__METHOD__,
			[ 'FOR UPDATE' ]
		);

		if ( is_object( $currentId ) ) {
			$id = (int)$currentId->pp_value + 1;
			$success = $database->update(
				'page_props',
				[ 'pp_value' => $id ],
				$this->getWhere( $type )
			);
		} else {
			$id = 1;

			$success = $database->insert(
				'page_props',
				$this->getInsertValues( $type, $id )
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

		return $id;
	}

	private function getInsertValues( string $idType, int $id ): array {
		$values = $this->getWhere( $idType );
		$values['pp_value'] = $id;
		return $values;
	}

	private function getWhere( string $idType ): array {
		return [
			'pp_page' => self::FAKE_PAGE_ID,
			'pp_propname' => $this->makePropertyName( $idType )
		];
	}

	private function makePropertyName( string $idType ): string {
		return 'id_' . $idType;
	}

}
