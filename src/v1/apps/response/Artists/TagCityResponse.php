<?php
namespace RodinAPI\Response\TagCities;

use RodinAPI\Response\Response;

class TagCityResponse extends Response
{

    /**
     * @var string
     */
    public $tag_id;

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
    public $locale_dk;

    /**
     * @var string
     */
    public $locale_en;

    /**
     * TagCityResponse constructor.
     * @param $tag_id
     * @param $country_code
     * @param $latitude
     * @param $longitude
     * @param $locale_dk
     * @param $locale_en
     */
    public function __construct( $tag_id, $country_code, $latitude, $longitude, $locale_dk, $locale_en )
    {
        $this->tag_id          = (string) $tag_id;
        $this->country_code    = (string) $country_code;
        $this->latitude        = (float) $latitude;
        $this->longitude       = (float) $longitude;
        $this->locale_dk       = (string) $locale_dk;
        $this->locale_en       = (string) $locale_en;

        parent::__construct();
    }

}