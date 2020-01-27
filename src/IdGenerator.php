<?php

declare( strict_types = 1 );

namespace IdGenerator;

use RuntimeException;

interface IdGenerator {

	/**
	 * @throws RuntimeException
	 */
	public function getNewId( string $type = '' ): int;

}
