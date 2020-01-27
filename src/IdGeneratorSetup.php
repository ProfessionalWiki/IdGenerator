<?php

declare( strict_types = 1 );

namespace IdGenerator;

use Parser;

class IdGeneratorSetup {

	public static function onExtensionFunction() {
		$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function ( Parser &$parser ) {
			foreach ( [ 'generate_id', 'generateid' ] as $functionName ) {
				$parser->setFunctionHook(
					$functionName,
					function ( Parser $parser, string $param = '' ) {
						return [
							'hi there' . $param, // TODO
						];
					}
				);
			}
		};
	}

}
