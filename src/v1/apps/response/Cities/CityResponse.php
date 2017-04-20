<?php
namespace RodinAPI\Response\Cities;

use RodinAPI\Models\LocaleTypes;
use RodinAPI\Response\Response;

class CityResponse extends Response
{

    /**
     * @var string
     */
    public $city_id;

    /**
     * @var string
     */
    public $country_code;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @var string
     */
    public $locales;

    /**
     * @var bool
     */
    public $searchable;

    /**
     * CityResponse constructor.
     * @param $city_id
     * @param $country_code
     * @param $latitude
     * @param $longitude
     * @param LocaleTypes $cityLocales
     * @param $searchable
     */
    public function __construct( $city_id, $country_code, $latitude, $longitude, LocaleTypes $cityLocales, $searchable )
    {
        $this->city_id         = (string) $city_id;
        $this->country_code    = (string) $country_code;
        $this->latitude        = (float) $latitude;
        $this->longitude       = (float) $longitude;
        $this->locales         = $cityLocales;
        $this->searchable      = (bool) $searchable;

        parent::__construct();
    }

}