<?php

namespace RodinAPI\Exceptions;

class InternalErrorException extends HandledException
{
  protected $code = 500;
  protected $message = 'Internal server error';
}
