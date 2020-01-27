<?php

namespace IdGenerator\Tests;

use PHPUnit\Framework\TestCase;

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
			$this->parse( "{{#generate_id:$idType}}" )
		);
	}

}
