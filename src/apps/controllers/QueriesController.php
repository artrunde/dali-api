<?php

namespace DaliAPI\Controllers;

use DaliAPI\Models\Tags;
use DaliAPI\Response\QueryPlaceResponse;
use DaliAPI\Response\QueryPlacesResponse;
use Phalcon\Mvc\Controller;

class QueriesController extends Controller
{

    private $tagResults = array();

    /**
     * @desc Create place query
     */
    public function createPlaceAction()
    {
        /**
         * Get JSON body as array
         */
        $body = $this->request->getJsonRawBody();

        $i = 0;

        /**
         *  Go through each searchable and query all items tagged
         */
        foreach($body->tags as $searchable) {

            /**
             * @var Tags $data
             */
            $data = Tags::factory('DaliAPI\Models\Tags')
            ->where('tag_id', '=', $searchable)
            ->findMany();

            foreach($data as $tag) {
                $this->tagResults[$i][$tag->place_id] = $searchable;
            }

            $i++;
        }

        /**
         *  array_intersect_key return only the array elements in common with the first array
         */
        $results = array_intersect_key($this->tagResults[0], $this->tagResults[1]);

        /**
         * Create array response
         */
        $response = new QueryPlacesResponse();

        foreach ( $results as $place_id => $tag_id) {

            $queryPlace = new QueryPlaceResponse($place_id, $tag_id);

            $response->addResponse($queryPlace);

        }

        return $response;

    }
}
