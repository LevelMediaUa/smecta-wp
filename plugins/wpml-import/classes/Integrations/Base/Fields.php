<?php

namespace WPML\Import\Integrations\Base;

trait Fields {

	private function getImportFields() {
		return [
			\WPML\Import\Fields::LANGUAGE_CODE,
			\WPML\Import\Fields::SOURCE_LANGUAGE_CODE,
			\WPML\Import\Fields::TRANSLATION_GROUP,
		];
	}

	/**
	 * @param  string $metaKey
	 * @param  object $element
	 *
	 * @return string|null
	 */
	private function getFieldValue( $metaKey, $element ) {
		switch ( $metaKey ) {
			case \WPML\Import\Fields::LANGUAGE_CODE:
				return $element->language_code;
			case \WPML\Import\Fields::SOURCE_LANGUAGE_CODE:
				return $element->source_language_code;
			case \WPML\Import\Fields::TRANSLATION_GROUP:
				return $element->trid;
		}
		return null;
	}
}
