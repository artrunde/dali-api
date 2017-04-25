<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Response\Debug\DebugResponse;
use RodinAPI\Response\Ping\PingResponse;

class IndexController extends BaseController
{
	public function indexAction()
	{
	    throw new ItemNotFoundException('The resource you tried to access, does not exist!');
	}

	public function debugAction()
	{

	    // AWS params
	    $eventParams    = json_decode(getenv('EVENT_PARAMS'),true);
        $contextParams  = json_decode(getenv('CONTEXT_PARAMS'),true);

        /**
         * Return debug response
         */
        return new DebugResponse(
            array('event_params' => $eventParams, 'context_params' => $contextParams)
        );

	}

    public function pingAction()
    {

        /**
         * Return debug response
         */
        return new PingResponse(
            array('message' => 'pong', 'method' => $this->request->getMethod(), 'body' => $this->request->getJsonRawBody())
        );

    }
}
