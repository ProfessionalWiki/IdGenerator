<?php

declare( strict_types = 1 );

namespace IdGenerator\Tests;

use IdGenerator\IdGenerator;
use IdGenerator\PackagePrivate\DatabaseIdGenerator;
use IdGenerator\PackagePrivate\PagePropsIdDatabase;
use MediaWiki\MediaWikiServices;
use PHPUnit\Framework\TestCase;

/**
 * @ingroup Database
 * @covers \IdGenerator\PackagePrivate\DatabaseIdGenerator
 * @covers \IdGenerator\PackagePrivate\PagePropsIdDatabase
 */
class PagePropsIdGeneratorTest extends TestCase {

	public function testIncrementsIdByOne() {
		$generator = $this->newGenerator();

		$this->assertSame(
			$generator->getNewId() + 1,
			$generator->getNewId()
		);
	}

	public function testIncrementsNamedId() {
		$generator = $this->newGenerator();

		$this->assertSame(
			$generator->getNewId( 'TestName' ) + 1,
			$generator->getNewId( 'TestName' )
		);
	}

	private function newGenerator(): IdGenerator {
		return new DatabaseIdGenerator(
			MediaWikiServices::getInstance()->getDBLoadBalancer(),
			new PagePropsIdDatabase()
		);
	}

}
