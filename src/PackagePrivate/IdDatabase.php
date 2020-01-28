<?php

declare( strict_types = 1 );

namespace IdGenerator\PackagePrivate;

use Wikimedia\Rdbms\IDatabase;

interface IdDatabase {

	public function getNewId( IDatabase $database, string $type ): int;

}
