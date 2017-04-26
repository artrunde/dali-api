<?php
namespace RodinAPI\Validators;

use Phalcon\Validation\Validator\PresenceOf;

class CityValidator extends BaseValidator {

	public function initialize()
    {

        $this->add(
            'country_code',
            new PresenceOf(
                array(
                    'message' => 'Country code is required'
                )
            )
        );

        $this->add(
            'country_code',
            new PresenceOf(
                array(
                    'message' => 'Country code is required'
                )
            )
        );

        $this->add(
            'latitude',
            new PresenceOf(
                array(
                    'message' => 'Latitude name is required'
                )
            )
        );

        $this->add(
            'longitude',
            new PresenceOf(
                array(
                    'message' => 'Longitude name is required'
                )
            )
        );

        $this->add(
            'searchable',
            new PresenceOf(
                array(
                    'message' => 'Searchable name is required'
                )
            )
        );

    }

}
