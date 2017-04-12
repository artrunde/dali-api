<?php

namespace RodinAPI\Controllers;

class SearchTermsController extends BaseController
{

    public function createAction()
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        foreach ($body->tags as $tag ) {



        }

    }

}
