<?php

namespace RodinAPI\Test\Integration;

use GuzzleHttp\Client;

abstract class BaseTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Client
     */
    protected $http;

    protected $suffix;

    public function setUp()
    {
        $this->http = new Client(
            [
                'base_uri'      => getenv('ACTIVE_V1_URL').$this->suffix,
                'http_errors'   => false
            ]
        );
    }

    public function tearDown()
    {
        $this->http = null;
    }

}