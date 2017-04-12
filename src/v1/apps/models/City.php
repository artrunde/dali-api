<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class City extends ODM {

    const CATEGORY = 'category_city';

	public $tag_id;

	public $belongs_to;

    public $country_code;

    public $latitude;

    public $longitude;

    public $locales;

    public $create_time;

	protected $_table_name = 'rodin_tags_v1';

	protected $_hash_key = 'tag_id';

    protected $_range_key = 'belongs_to';

	protected $_schema = array(
        'tag_id'        => 'S',
        'belongs_to'    => 'S',
        'country_code'  => 'S',
        'latitude'      => 'N',
        'locales'       => 'M', // Map
        'longitude'     => 'N',
        'create_time'   => 'S'
	);

    final public static function getCategory()
    {
        return str_replace('category_', '', self::CATEGORY);
    }

    /**
     * @param $country_code
     * @param $latitude
     * @param $longitude
     * @param $locales
     * @return City $city
     */
    public static function createCityTag( $country_code, $latitude, $longitude, $locales )
    {
        $city = City::factory('RodinAPI\Models\City')->create();

        $city_id             = uniqid('city_');

        $city->tag_id        = $city_id;
        $city->belongs_to    = self::CATEGORY;
        $city->country_code  = $country_code;
        $city->latitude      = $latitude;
        $city->longitude     = $longitude;
        $city->locales       = json_encode($locales);;
        $city->create_time   = date('c');

        $city->save();

        return $city;
    }
}