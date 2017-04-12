<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\SearchTerms;
use RodinAPI\Models\Tags;
use RodinAPI\Response\TagResponse;
use RodinAPI\Response\TagsResponse;

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
