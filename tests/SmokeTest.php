<?php

declare( strict_types = 1 );

namespace IdGenerator\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @ingroup Database
 */
class SmokeTest extends TestCase {

	private function parse( string $textToParse ): string {
		$parser = new \Parser();
		$options = new \ParserOptions();
		$options->setOption( 'wrapclass', false );

		return $parser->parse( $textToParse, \Title::newMainPage(), $options )->getText();
	}

	public function testSmoke() {
		$idType = (string)rand() . (string)rand();

		$this->assertContains(
			"<p>1\n",
			$this->parse( "{{#next_number:$idType}}" )
		);
	}

}
