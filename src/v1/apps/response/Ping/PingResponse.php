<?php
namespace RodinAPI\Response\Ping;

use RodinAPI\Response\Response;

class PingResponse extends Response
{
    /**
     * @var string
     */
    public $params = null;

    /**
     * DebugResponse constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;

        parent::__construct();
    }
}