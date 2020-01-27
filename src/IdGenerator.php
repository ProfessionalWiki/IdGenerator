<?php

declare( strict_types = 1 );

namespace NumericId;

use RuntimeException;

interface IdGenerator {

	/**
	 * @throws RuntimeException
	 */
	public function getNewId( string $type = '' ): int;

}

