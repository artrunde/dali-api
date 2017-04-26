<?php
namespace RodinAPI\Validators;

use Phalcon\Validation\Validator\PresenceOf;

class PlaceLocaleValidator extends BaseValidator {

	public function initialize()
    {

        $this->add(
            'place_name',
            new PresenceOf(
                array(
                    'message' => 'Place name is required'
                )
            )
        );

        $this->add(
            'address1_name',
            new PresenceOf(
                array(
                    'message' => 'Address is required'
                )
            )
        );

        $this->add(
            'postal_code',
            new PresenceOf(
                array(
                    'message' => 'Postal code is required'
                )
            )
        );

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
