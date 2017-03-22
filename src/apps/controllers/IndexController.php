<?php

namespace DaliAPI\Controllers;

use DaliAPI\Response\DebugResponse;

class IndexController extends BaseController
{
	public function indexAction()
	{
		$this->response->setJsonContent(array('nothing to see here' => $this->request->getQuery()));
		$this->response->send();
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
