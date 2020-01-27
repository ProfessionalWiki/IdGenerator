<?php

declare( strict_types = 1 );

namespace NumericId;

use Parser;

class NumericIdSetup {

	public static function onExtensionFunction() {
		$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function ( Parser &$parser ) {
			foreach ( [ 'numeric_id', 'numericid' ] as $functionName ) {
				$parser->setFunctionHook(
					$functionName,
					function ( Parser $parser, string $param = '' ) {
						return [
							'hi there' . $param, // TODO
							'noparse' => true,
							'isHTML' => false,
						];
					}
				);
			}
		};
	}

}
