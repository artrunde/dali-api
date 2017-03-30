<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Models\Tags;
use RodinAPI\Response\QueryPlaceResponse;
use RodinAPI\Response\QueryPlacesResponse;

class QueriesController extends BaseController
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

        if ( count($body->tags) < 4 && count($body->tags) > 0) {

            // Create result arrays
            $this->tagResults = Tags::createQueryPlaceResult($body->tags);

            /**
             *  array_intersect_key return only the array elements in common with the first array
             */
            if( count($body->tags) == 2) {
                $results = array_intersect_key($this->tagResults[0], $this->tagResults[1]);
            } elseif (count($body->tags) == 3) {
                $results = array_intersect_key($this->tagResults[0], $this->tagResults[1], $this->tagResults[2]);
            } else {
                $results = $this->tagResults[0];
            }

            /**
             * Create array response
             */
            $response = new QueryPlacesResponse();

            if (!empty($results)) {

                foreach ($results as $place_id => $tag_id) {

                    $queryPlace = new QueryPlaceResponse($place_id, $tag_id);

                    $response->addResponse($queryPlace);

                }

            }

            return $response;

        } else {

            throw new BadRequestException('Invalid number of search tags, min:1 max:3');

        }

    }
}
