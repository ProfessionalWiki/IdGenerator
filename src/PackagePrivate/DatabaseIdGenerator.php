<?php

declare( strict_types = 1 );

namespace IdGenerator\PackagePrivate;

use IdGenerator\IdGenerator;
use Wikimedia\Rdbms\ILoadBalancer;

class DatabaseIdGenerator implements IdGenerator {

	private $loadBalancer;
	private $idDatabase;

	public function __construct( ILoadBalancer $loadBalancer, IdDatabase $idDatabase ) {
		$this->loadBalancer = $loadBalancer;
		$this->idDatabase = $idDatabase;
	}

	public function getNewId( string $type = '' ): int {
		$database = $this->loadBalancer->getConnection( DB_MASTER );

		$database->startAtomic( __METHOD__ );

		$id = $this->idDatabase->getNewId( $database, $type );

		$database->endAtomic( __METHOD__ );

		$this->loadBalancer->reuseConnection( $database );

		return $id;
	}

}
