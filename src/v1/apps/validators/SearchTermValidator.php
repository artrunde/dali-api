<?php
namespace RodinAPI\Validators;

use Phalcon\Validation\Validator\PresenceOf;

class SearchTermValidator extends BaseValidator {

	public function initialize()
    {

        $this->add(
            'search_term',
            new PresenceOf(
                array(
                    'message' => 'Search term is required'
                )
            )
        );

        $this->add(
            'label',
            new PresenceOf(
                array(
                    'message' => 'Label is required'
                )
            )
        );

        $this->add(
            'belongs_to',
            new PresenceOf(
                array(
                    'message' => 'Belongs_to is required'
                )
            )
        );

    }

}
