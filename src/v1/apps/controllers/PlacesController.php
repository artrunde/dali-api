<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\Places;
use RodinAPI\Response\PlaceResponse;
use RodinAPI\Response\PlacesResponse;

class PlacesController extends BaseController
{

    public function getAction($place_id)
    {
        // Get place
        $place = Places::factory('RodinAPI\Models\Places')->findOne($place_id);

        if(empty($place)) {
            throw new ItemNotFoundException();
        } else {
            return new PlaceResponse($place->place_id, $place->url_id);
        }

    }

    public function createPlaceAction()
    {

        $body = $this->request->getJsonRawBody();

        if( !empty($body->url_id) ) {

            // Get place
            $place = Places::factory('RodinAPI\Models\Places')->create();

            $place->url_id      = $body->url_id;
            $place->place_id    = uniqid();

            $place->save();

            return new PlaceResponse($place->place_id , $place->url_id);

        } else {
            throw new BadRequestException('Bad place request');
        }

    }

    /**
     * @return PlacesResponse
     * @throws BadRequestException
     * @throws ItemNotFoundException
     */
    public function getBulkAction()
    {

        $queryItems = array_unique($this->queryItems);

        if(count($queryItems) > 0 && count($queryItems) < 11) {

            // Get place
            $places = Places::factory('RodinAPI\Models\Places')->batchGetItems(
                $queryItems
            );

            if (empty($places)) {

                throw new ItemNotFoundException();

            } else {

                $response = new PlacesResponse();

                foreach ($places as $place) {
                    $response->addResponse(new PlaceResponse($place->place_id, $place->url_id));
                }

                return $response;

            }

        } else {

            throw new BadRequestException('Invalid number of query items. min:1 and max:10');

        }

    }
}
