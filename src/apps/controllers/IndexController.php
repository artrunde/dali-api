<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Response\DebugResponse;

class IndexController extends BaseController
{
	public function indexAction()
	{
	    throw new ItemNotFoundException('The resource you tried to access, does not exist!');
	}

	public function debugAction()
	{
        /**
         * Return debug response
         */
        return new DebugResponse(
            json_decode(getenv('EVENT_PARAMS'),true)
        );
	}
}
