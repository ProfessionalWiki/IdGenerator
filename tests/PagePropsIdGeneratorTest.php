<?php

declare( strict_types = 1 );

namespace IdGenerator\Tests;

use IdGenerator\PackagePrivate\PagePropsIdGenerator;
use MediaWiki\MediaWikiServices;
use PHPUnit\Framework\TestCase;

/**
 * @ingroup Database
 * @covers \IdGenerator\PackagePrivate\PagePropsIdGenerator
 */
class PagePropsIdGeneratorTest extends TestCase {

	public function testIncrementsIdByOne() {
		$generator = new PagePropsIdGenerator( MediaWikiServices::getInstance()->getDBLoadBalancer() );

		$this->assertSame(
			$generator->getNewId() + 1,
			$generator->getNewId()
		);
	}

	public function testIncrementsNamedId() {
		$generator = new PagePropsIdGenerator( MediaWikiServices::getInstance()->getDBLoadBalancer() );

		$this->assertSame(
			$generator->getNewId( 'TestName' ) + 1,
			$generator->getNewId( 'TestName' )
		);
	}

}
