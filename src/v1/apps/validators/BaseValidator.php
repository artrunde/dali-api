<?php
namespace RodinAPI\Validators;

use Phalcon\Validation;

use RodinAPI\Exceptions\ValidatorException;

abstract class BaseValidator extends Validation {

	public function validate($data = null, $entity = null) {
		
		$messages = parent::validate($data, $entity);
				
		// Check messages
		if( count($messages) > 0 ):

			$exception = new ValidatorException();

            $exception->addValidatorMessages($messages);

            throw $exception;

		endif;
		
		return true;		
	}
}
