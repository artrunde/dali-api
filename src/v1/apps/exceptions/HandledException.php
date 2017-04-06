<?php

namespace RodinAPI\Exceptions;

/**
 * HandledException
 * Any Exception that extends this will be handled in the response object,
 * Any non-handled exceptions will work as normal
 */
class HandledException extends \Exception
{

    protected $code = 500;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        if (isset($this->message) && $message == '') {
            $message = $this->message;
        }

        if ($code !== 0) {
            $this->code = $code;
        }

        parent::__construct($message, $this->code, $previous);
    }
}
