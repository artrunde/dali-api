<?php
namespace RodinAPI\Response\Cities;

use RodinAPI\Response\Response;

class PlaceDeleteResponse extends Response
{

    /**
     * @var string
     */
    public $city_id;

    /**
     * CityDeleteResponse constructor.
     * @param $city_id
     */
    public function __construct( $city_id )
    {
        $this->city_id = (string) $city_id;

        parent::__construct();
    }

}