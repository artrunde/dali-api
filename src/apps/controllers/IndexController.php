<?php

namespace DaliAPI\Controllers;

use DaliAPI\Response\DebugResponse;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
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
            getenv('EVENT_PARAMS')
        );
	}
}
