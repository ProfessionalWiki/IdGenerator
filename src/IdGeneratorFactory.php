<?php

declare( strict_types = 1 );

namespace IdGenerator;

use IdGenerator\PackagePrivate\DatabaseIdGenerator;
use IdGenerator\PackagePrivate\PagePropsIdDatabase;
use Wikimedia\Rdbms\ILoadBalancer;

class IdGeneratorFactory {

	private $generator;

	public function getIdGenerator( ILoadBalancer $loadBalancer ): IdGenerator {
		if ( $this->generator === null ) {
			$this->generator = new DatabaseIdGenerator(
				$loadBalancer,
				new PagePropsIdDatabase()
			);
		}

		return $this->generator;
	}

}
