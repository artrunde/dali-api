<?php
namespace RodinAPI\Response\Cities;

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
     * TagCityResponse constructor.
     * @param $city_id
     * @param $country_code
     * @param $latitude
     * @param $longitude
     * @param $locales
     */
    public function __construct( $city_id, $country_code, $latitude, $longitude, $locales )
    {
        $this->city_id         = (string) $city_id;
        $this->country_code    = (string) $country_code;
        $this->latitude        = (float) $latitude;
        $this->longitude       = (float) $longitude;
        $this->locales         = json_decode($locales);

        parent::__construct();
    }

}