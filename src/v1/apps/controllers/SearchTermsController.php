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

        // TODO get the from ODM
        $tag1 = Tags::factory('RodinAPI\Models\Tags');
        $tag2 = Tags::factory('RodinAPI\Models\Tags');
        $tag3 = Tags::factory('RodinAPI\Models\Tags');
        $tag4 = Tags::factory('RodinAPI\Models\Tags');

        $tag1->tag_id = 'aaaaaaaa';
        $tag1->category = 'city';
        $tag1->info = array("en" => array("name" => "Berlin, Germany"));
        $tag1->create_time = "2010-12-21T17:42:34+00:00";

        $tag2->tag_id = 'bbbbbbbb';
        $tag2->category = 'city';
        $tag2->info = array("en" => array("name" => "Bergen, Norway"));
        $tag2->create_time = "2012-12-21T17:42:34+00:00";

        $tag3->tag_id = 'cccccccc';
        $tag3->category = 'art_form';
        $tag3->info = array("en" => array("name" => "Art Deco"));
        $tag3->create_time = "2013-11-21T17:42:34+00:00";

        $tag4->tag_id = 'dddddddd';
        $tag4->category = 'art_form';
        $tag4->info = array("en" => array("name" => "Modern Art"));
        $tag4->create_time = "2013-11-21T17:42:34+00:00";

        $response1 = new TagResponse($tag1->tag_id, $tag1->category, $tag1->info, $tag1->create_time);
        $response2 = new TagResponse($tag2->tag_id, $tag2->category, $tag2->info, $tag2->create_time);
        $response3 = new TagResponse($tag3->tag_id, $tag3->category, $tag3->info, $tag3->create_time);
        $response4 = new TagResponse($tag4->tag_id, $tag4->category, $tag4->info, $tag4->create_time);

	    $query      = $this->request->getQuery('query');
        $category   = $this->request->getQuery('category');

        if(!empty($category)) {
            // Parse category
            $category = explode(',',$category);
        }

	    // Check query param
        if( !empty($query) || !empty($category) ) {

            $responseArray = new TagsResponse();

            if( empty($category) || in_array('all', $category) ) {

                $responseArray->addResponse($response1);
                $responseArray->addResponse($response2);
                $responseArray->addResponse($response3);
                $responseArray->addResponse($response4);

            } else {

                $responseArray->addResponse($response3);
                $responseArray->addResponse($response4);

            }

            return $responseArray;

        } else {
            throw new BadRequestException('Invalid query');
        }

	}

}
