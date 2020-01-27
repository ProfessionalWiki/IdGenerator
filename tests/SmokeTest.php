<?php

namespace IdGenerator\Tests;

use PHPUnit\Framework\TestCase;

class SmokeTest extends TestCase {

	private function parse( string $textToParse ): string {
		$parser = new \Parser();

		return $parser->parse( $textToParse, \Title::newMainPage(), new \ParserOptions() )->getText();
	}

	public function testSmoke() {
		$this->assertContains(
			'hi theresuch',
			$this->parse( '{{#generate_id:such}}' )
		);
	}

}
