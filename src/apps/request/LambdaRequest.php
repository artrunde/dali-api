<?php

namespace DaliAPI\Request;

use Phalcon\Http\Request;

class LambdaRequest extends Request {

    public function __construct()
    {
        $this->_rawBody = file_get_contents('php://stdin');
    }

    public function getRawBody()
    {
        return $this->_rawBody;
    }

    public function isJSON()
    {
        return true; // TODO
    }

    public function envelope()
    {
        $headers = $this->getHeaders();

        return empty($headers['X-envelope']) ? false : true;
    }

}