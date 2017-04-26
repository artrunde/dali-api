<?php

namespace RodinAPI\Models;

use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Library\ODM;
use RodinAPI\Validators\CityValidator;

class City extends ODM {

    const CATEGORY = 'category_city';

	public $tag_id;

	public $belongs_to;

    public $country_code;

    public $latitude;

    public $longitude;

    public $locales;

    public $searchable;

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
        'searchable'    => 'BOOL',
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
     * @param LocaleTypes $locales
     * @param $searchable
     * @return $this
     */
    public static function createCityTag( $country_code, $latitude, $longitude, LocaleTypes $locales, $searchable )
    {
        $city = City::factory('RodinAPI\Models\City')->create();

        $city_id             = uniqid();

        $city->tag_id        = $city_id;
        $city->belongs_to    = self::CATEGORY;
        $city->country_code  = $country_code;
        $city->latitude      = $latitude;
        $city->longitude     = $longitude;
        $city->locales       = json_encode($locales);
        $city->create_time   = date('c');
        $city->searchable    = $searchable;

        /**
         * Validate request
         */
        if( $city->validate(new CityValidator())  === true ) {

            $city->save();

            if( true === $city->searchable ) {

                $searchTerm = SearchTermFactory::factory( $city->tag_id, 'city' );
                $searchTerm->create();

            }

            return $city;

        }


    }

    /**
     * @param $place_id
     * @param $city_id
     * @return City
     */
    public static function createTagRelation($place_id, $city_id)
    {

        $tagRelation = Tag::factory('RodinAPI\Models\Tag')->create();

        $tagRelation->tag_id        = $city_id;
        $tagRelation->belongs_to    = 'place_'.$place_id;
        $tagRelation->category      = City::getCategory();
        $tagRelation->create_time   = date('c');

        $tagRelation->save();

        // Get city data
        return City::factory('RodinAPI\Models\City')->findOne($city_id, City::CATEGORY);


    }

}