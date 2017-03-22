<?php

namespace DaliAPI\Controllers;

use Phalcon\Mvc\Controller;

abstract class BaseController extends Controller
{

    protected $isSearch;

    protected $limit = 10;

    protected $queryItems;

    public function initialize()
    {
        $this->parseRequest();
    }

    private function parseRequest()
    {

        $this->isSearch     = empty( $this->request->get('q') ) ? false : true;
        $this->limit        = ( $this->request->get('limit') ) ?: $this->limit;

        if ($this->isSearch === true) {

            /**
             * + sign in URl changes to space. https://forums.aws.amazon.com/thread.jspa?messageID=722673
             */
            $this->queryItems = explode(' ',$this->request->get('q', null, null));
        }

    }

}
