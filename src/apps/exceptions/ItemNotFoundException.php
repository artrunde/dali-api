<?php

namespace RodinAPI\Exceptions;

class ItemNotFoundException extends HandledException
{
    protected $code = 404;
    protected $message = 'The item(s) you requested could not be found';
}
