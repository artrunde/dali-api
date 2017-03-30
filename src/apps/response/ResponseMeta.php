<?php

namespace DaliAPI\Response;

class ResponseMeta
{

    public function __construct()
    {
        $this->version = file_get_contents(__DIR__ . '/../../../version');
    }

    /** @var int */
    public $statusCode = 200;

    /** @var string */
    public $statusMessage = 'OK';

    /** @var int */
    public $count;

    /** @var string */
    public $version;

}
