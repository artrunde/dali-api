<?php

namespace RodinAPI\Response;

class ResponseMeta
{

    public function __construct()
    {
        $this->version      = trim(file_get_contents(__DIR__ . '/../../../version'));
        $this->environment  = getenv('ENVIRONMENT');
        $this->stage        = getenv('STAGE');

    }

    /** @var int */
    public $statusCode = 200;

    /** @var string */
    public $statusMessage = 'OK';

    /** @var int */
    public $count;

    /** @var string */
    public $version;

    /**
     * @var string
     */
    public $environment;

    /**
     * @var string
     */
    public $stage;

}
