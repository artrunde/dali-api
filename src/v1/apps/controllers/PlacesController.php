<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Factories\LocaleFactory;
use RodinAPI\Models\Place;
use RodinAPI\Response\Places\PlaceAdminResponse;

class PlacesController extends BaseController
{

    /**
     * @param $place_id
     * @return PlaceAdminResponse
     * @throws ItemNotFoundException
     */
    public function getAction($place_id)
    {

        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            // Create locales
            $placeLocales = LocaleFactory::create('place', $place->locales);

            return new PlaceAdminResponse( $place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code, $place->status, $place->create_time );
        }

        throw new ItemNotFoundException('Could not find specified place');

    }

    /**
     * @return PlaceAdminResponse
     * @throws BadRequestException
     */
    public function createAction()
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        // Create locales
        $placeLocales = LocaleFactory::create('place', $body->locales);

        $place = Place::createPlace($body->url, $placeLocales, $body->latitude, $body->longitude, $body->country_code, $body->status);

        if( $place !== false ) {

            return new PlaceAdminResponse( $place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code, $place->status, $place->create_time );

        } else {
            throw new BadRequestException('Place does already exist');
        }

    }


}
