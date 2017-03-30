<?php
namespace RodinAPI\Response;

class DebugResponse extends Response
{
    /**
     * @var string
     */
    public $event_params = null;

    /**
     * @param string $env_params
     */
    public function __construct($event_params)
    {
        $this->event_params = $event_params;

        parent::__construct();
    }
}