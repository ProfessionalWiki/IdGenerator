<?php

namespace IdGenerator\PackagePrivate;

use Wikimedia\Rdbms\IDatabase;

class PagePropsIdDatabase implements IdDatabase {

	private const FAKE_PAGE_ID = -42;

	/**
	 * @var IDatabase
	 */
	private $database;

	public function getNewId( IDatabase $database, string $type ): int {
		$this->database = $database;

		$id = $this->getId( $type );

		$this->storeId( $type, $id );

		return $id;
	}

	private function getId( string $type ): int {
		$currentId = $this->database->selectRow(
			'page_props',
			'pp_value',
			$this->getWhere( $type ),
			__METHOD__,
			[ 'FOR UPDATE' ]
		);

		if ( is_object( $currentId ) ) {
			return (int)$currentId->pp_value + 1;
		}

		return 1;
	}

	private function storeId( string $type, int $id ): bool {
		if ( $id === 1 ) {
			return $this->database->insert(
				'page_props',
				$this->getInsertValues( $type, $id )
			);
		}

		return $this->database->update(
			'page_props',
			[ 'pp_value' => $id ],
			$this->getWhere( $type )
		);
	}

	private function getInsertValues( string $idType, int $id ): array {
		$values = $this->getWhere( $idType );
		$values['pp_value'] = $id;
		return $values;
	}

	private function getWhere( string $idType ): array {
		return [
			'pp_page' => self::FAKE_PAGE_ID,
			'pp_propname' => $this->makePropertyName( $idType )
		];
	}

	private function makePropertyName( string $idType ): string {
		return 'id_' . $idType;
	}

}
