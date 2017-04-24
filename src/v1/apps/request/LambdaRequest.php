<?php

namespace RodinAPI\Request;

use Phalcon\Http\Request;

class LambdaRequest extends Request {

    public function getJsonRawBody($associative = false)
    {
        return json_decode(getenv('BODY_JSON'), $associative);
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