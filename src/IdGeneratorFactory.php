<?php

declare( strict_types = 1 );

namespace IdGenerator;

use IdGenerator\PackagePrivate\PagePropsIdGenerator;
use Wikimedia\Rdbms\ILoadBalancer;

class IdGeneratorFactory {

	private $generator;

	public function getIdGenerator( ILoadBalancer $loadBalancer ): IdGenerator {
		if ( $this->generator === null ) {
			$this->generator = new PagePropsIdGenerator( $loadBalancer );
		}

		return $this->generator;
	}

}
