<?php

namespace RodinAPI\Models;

class PlaceLocale extends Locale  {

    public $address1_name;

    public $address2_name;

    public $postal_code;

    public $city_name;

    public $country_name;

    public function __construct($address1_name, $address2_name, $postal_code, $city_name, $country_name)
    {
        $this->address1_name      = (string) $address1_name;
        $this->address2_name      = empty($address2_name) ? null : $address2_name;
        $this->postal_code        = (string) $postal_code;
        $this->city_name          = (string) $city_name;
        $this->country_name       = (string) $country_name;
    }

}