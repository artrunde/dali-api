<?php

namespace RodinAPI\Models;

class CityLocale extends Locale  {

    public $city_name;

    public $country_name;

    public function __construct($city_name, $country_name)
    {
        $this->city_name    = $city_name;
        $this->country_name = $country_name;
    }

}