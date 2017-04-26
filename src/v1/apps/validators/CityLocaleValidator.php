<?php
namespace RodinAPI\Validators;

use Phalcon\Validation\Validator\PresenceOf;

class CityLocaleValidator extends BaseValidator {

	public function initialize()
    {

        $this->add(
            'city_name',
            new PresenceOf(
                array(
                    'message' => 'City name is required'
                )
            )
        );

        $this->add(
            'country_name',
            new PresenceOf(
                array(
                    'message' => 'Country name is required'
                )
            )
        );

    }

}
