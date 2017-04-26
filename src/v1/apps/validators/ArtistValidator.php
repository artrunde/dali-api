<?php
namespace RodinAPI\Validators;

use Phalcon\Validation\Validator\ExclusionIn;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;

class ArtistValidator extends BaseValidator {

	public function initialize()
    {

        $this->add(
            'born_date',
            new PresenceOf(
                array(
                    'message' => 'Born date is required'
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
                        "deceased",
                        "fictive",
                        "alive"
                    ],
                ]
            )
        );

        $this->add(
            'searchable',
            new PresenceOf(
                array(
                    'message' => 'Searchable is required'
                )
            )
        );

    }

}
