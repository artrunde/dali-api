<?php

namespace RodinAPI\Models;

/**
 * Class TagCategories
 * @package RodinAPI\Models
 */
class TagLabels extends VirtualModel {

	const ACCEPTED_LOCALES = array('en','dk');

	public static function validLocale( $locale ) {
        return in_array( $locale, self::ACCEPTED_LOCALES );
    }

}