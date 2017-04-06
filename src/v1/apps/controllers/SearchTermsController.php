<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Models\Tags;
use RodinAPI\Response\TagResponse;
use RodinAPI\Response\TagsResponse;

class SearchTermsController extends BaseController
{

	public function searchAction()
	{

	    $query = $this->request->getQuery('query');

	    // Check query param
        if( !empty($query) ) {

            // TODO get the from ODM
            $tag1 = Tags::factory('RodinAPI\Models\Tags');
            $tag3 = Tags::factory('RodinAPI\Models\Tags');
            $tag2 = Tags::factory('RodinAPI\Models\Tags');

            $tag1->tag_id = '553677a0000';
            $tag1->category = 'city';
            $tag1->info = array("en" => array("name" => "Berlin, Germany"));
            $tag1->create_time = "2010-12-21T17:42:34+00:00";


            $tag2->tag_id = 'accd212eee';
            $tag2->category = 'city';
            $tag2->info = array("en" => array("name" => "Bergen, Norway"));
            $tag2->create_time = "2012-12-21T17:42:34+00:00";

            $tag3->tag_id = '0166ab3516';
            $tag3->category = 'city';
            $tag3->info = array("en" => array("name" => "Bergois, France"));
            $tag3->create_time = "2013-11-21T17:42:34+00:00";

            $responseArray = new TagsResponse();

            $response1 = new TagResponse($tag1->tag_id, $tag1->category, $tag1->info, $tag1->create_time);
            $response2 = new TagResponse($tag2->tag_id, $tag2->category, $tag2->info, $tag2->create_time);
            $response3 = new TagResponse($tag3->tag_id, $tag3->category, $tag3->info, $tag3->create_time);

            $responseArray->addResponse($response1);
            $responseArray->addResponse($response2);
            $responseArray->addResponse($response3);

            return $responseArray;

        } else {
            throw new BadRequestException('Invalid query');
        }

	}

}
