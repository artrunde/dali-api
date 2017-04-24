<?php
namespace RodinAPI\Response\Tags;

use RodinAPI\Response\Response;

class TagCityResponse extends Response
{

    /**
     * @var string
     */
    public $city_id;

    /**
     * CityResponse constructor.
     * @param $city_id
     */
    public function __construct( $city_id )
    {
        $this->city_id  = (string) $city_id;

        parent::__construct();
    }

}