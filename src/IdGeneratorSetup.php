<?php

declare( strict_types = 1 );

namespace IdGenerator;

use MediaWiki\MediaWikiServices;
use Parser;

class IdGeneratorSetup {

	/**
	 * @var IdGeneratorFactory
	 */
	private static $factory;

	public static function onExtensionFunction() {
		self::$factory = new IdGeneratorFactory();

		$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function ( Parser &$parser ) {
			foreach ( [ 'next_number', 'nextnumber' ] as $functionName ) {
				$parser->setFunctionHook(
					$functionName,
					function ( Parser $parser, string $param = '' ) {
						$generator = self::$factory->getIdGenerator(
							MediaWikiServices::getInstance()->getDBLoadBalancer()
						);

						return [
							$generator->getNewId( $param ),
							'noparse' => true
						];
					}
				);
			}
		};
	}

}
