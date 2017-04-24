<?php

namespace RodinAPI\Models;

use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Library\ODM;

class Place extends ODM {

	public $place_id;

	public $url;

    public $locales;

    public $latitude;

    public $longitude;

    public $country_code;

    public $status;

    public $searchable;

    public $create_time;

	protected $_table_name = 'rodin_places_v1';

	protected $_hash_key = 'place_id';

	protected $_schema = array(
        'place_id'     => 'S',
        'url'          => 'S',
        'locales'      => 'M',
        'latitude'     => 'N',
        'longitude'    => 'N',
        'country_code' => 'S',
        'status'       => 'S',
        'searchable'   => 'BOOL',
        'create_time'  => 'S'
	);

    /**
     * @param $url
     * @param LocaleTypes $locales
     * @param $latitude
     * @param $longitude
     * @param $country_code
     * @param $status
     * @return $this
     */
    public static function createPlace( $url, LocaleTypes $locales, $latitude, $longitude, $country_code, $status, $searchable )
    {

        $place = Place::factory('RodinAPI\Models\Place')->create();

        $place_id               = uniqid();

        $place->place_id        = $place_id;
        $place->url             = $url;
        $place->country_code    = $country_code;
        $place->latitude        = $latitude;
        $place->longitude       = $longitude;
        $place->locales         = json_encode($locales);
        $place->status          = $status;
        $place->searchable      = (bool) $searchable;
        $place->create_time     = date('c');

        $place->save();

        // Check if searchable
        if( true === $place->searchable ) {

            $searchTerm = SearchTermFactory::factory( $place->place_id, 'place' );
            $searchTerm->create();

        }

        return $place;
    }
}