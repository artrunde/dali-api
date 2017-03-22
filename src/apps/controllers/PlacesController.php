<?php

namespace DaliAPI\Controllers;

use DaliAPI\Exceptions\BadRequestException;
use DaliAPI\Exceptions\ItemNotFoundException;
use DaliAPI\Models\Places;
use DaliAPI\Response\PlaceResponse;
use DaliAPI\Response\PlacesResponse;

class PlacesController extends BaseController
{

    public function getAction($place_id)
    {
        // Get place
        $place = Places::factory('DaliAPI\Models\Places')->findOne($place_id);

        if(empty($place)) {
            throw new ItemNotFoundException();
        } else {
            return new PlaceResponse($place->place_id, $place->url_id);
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
            $places = Places::factory('DaliAPI\Models\Places')->batchGetItems(
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
