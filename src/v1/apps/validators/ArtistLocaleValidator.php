<?php
namespace RodinAPI\Validators;

use Phalcon\Validation\Validator\PresenceOf;

class ArtistLocaleValidator extends BaseValidator {

	public function initialize()
    {

        $this->add(
            'first_name',
            new PresenceOf(
                array(
                    'message' => 'First name is required'
                )
            )
        );

        $this->add(
            'last_name',
            new PresenceOf(
                array(
                    'message' => 'Last name is required'
                )
            )
        );

    }

}
