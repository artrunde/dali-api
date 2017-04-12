<?php
namespace RodinAPI\Response\Debug;

use RodinAPI\Response\Response;

class DebugResponse extends Response
{
    /**
     * @var string
     */
    public $event_params = null;

    /**
     * DebugResponse constructor.
     * @param $event_params
     */
    public function __construct($event_params)
    {
        $this->event_params = $event_params;

        parent::__construct();
    }
}