<?php
namespace RodinAPI\Validators;

use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;

class PlaceValidator extends BaseValidator {

	public function initialize()
    {

        $this->add(
            'url',
            new PresenceOf(
                array(
                    'message' => 'URL is required'
                )
            )
        );

        $this->add(
            'latitude',
            new PresenceOf(
                array(
                    'message' => 'Latitude is required'
                )
            )
        );

        $this->add(
            'longitude',
            new PresenceOf(
                array(
                    'message' => 'Longitude is required'
                )
            )
        );

        $this->add(
            'status',
            new PresenceOf(
                array(
                    'message' => 'Status is required'
                )
            )
        );

        $this->add(
            'status',
            new InclusionIn(
                [
                    "message" => "The status is not valid",
                    "domain"  => [
                        "active",
                        "closed",
                        "historic"
                    ],
                ]
            )
        );

        $this->add(
            'searchable',
            new PresenceOf(
                array(
                    'message' => 'searchable name is required'
                )
            )
        );

    }

}
