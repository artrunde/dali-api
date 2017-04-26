<?php

namespace RodinAPI\Exceptions;

class ValidatorException extends BadRequestException
{

    protected $code = 400;
    protected $message = 'Could not validate request';

}