<?php
namespace RodinAPI\Response\Places;

use RodinAPI\Models\LocaleTypes;
use RodinAPI\Response\Response;

class PlaceQueryResponse extends Response
{

    /**
     * @var string
     */
    public $place_id;

    /**
     * @var string
     */
    public $url;

    /**
     * @var LocaleTypes
     */
    public $locales;

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
    public $country_code;

    /**
     * PlaceAdminResponse constructor.
     * @param $place_id
     * @param $url
     * @param LocaleTypes $locales
     * @param $latitude
     * @param $longitude
     * @param $country_code
     */
    public function __construct( $place_id, $url, LocaleTypes $locales, $latitude, $longitude, $country_code )
    {
        $this->place_id         = (string) $place_id;
        $this->url              = (string) $url;
        $this->locales          = $locales;
        $this->latitude         = (float) $latitude;
        $this->longitude        = (float) $longitude;
        $this->country_code     = $country_code;

        parent::__construct();
    }

}