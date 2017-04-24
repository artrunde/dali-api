<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Factories\LocaleFactory;
use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Models\Artist;
use RodinAPI\Models\City;
use RodinAPI\Models\Locale;
use RodinAPI\Models\Place;
use RodinAPI\Models\PlaceLocale;
use RodinAPI\Models\SearchTerm;
use RodinAPI\Models\Tag;
use RodinAPI\Response\Places\PlaceDeleteResponse;
use RodinAPI\Response\Places\PlaceAdminResponse;
use RodinAPI\Response\Places\PlaceQueryResponse;
use RodinAPI\Response\PlacesResponse;

class PlacesController extends BaseController
{

    public function deleteAction($place_id)
    {

        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if ( !empty($place) ) {

            $place->delete();

            // Delete terms as well
            SearchTerm::deleteSearchTerm($place->place_id);

            return new PlaceDeleteResponse($place_id);
        }

        throw new ItemNotFoundException('Could not find specified place');

    }

    /**
     * @param $place_id
     * @return PlaceAdminResponse
     * @throws ItemNotFoundException
     */
    public function getAction($place_id)
    {

        // try place_id second
        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            // Create locales
            $placeLocales = LocaleFactory::create('place', $place->locales);

            return new PlaceAdminResponse( $place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code, $place->status, $place->searchable, $place->create_time );

        }

        throw new ItemNotFoundException('Could not find specified place');

    }

    /**
     * @param $identifier
     * @return PlaceQueryResponse
     * @throws ItemNotFoundException
     */
    public function getPublicAction($identifier)
    {

        // try by url first
        $place = Place::factory('RodinAPI\Models\Place')->where('url','=',$identifier)->index('urlIndex')->findFirst();

        if( !empty($place) ) {

            // Create locales
            $placeLocales = LocaleFactory::create('place', $place->locales);

            return new PlaceQueryResponse($place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code);

        } else {

            // try place_id second
            $place = Place::factory('RodinAPI\Models\Place')->findOne($identifier);

            if( !empty($place) ) {

                // Create locales
                $placeLocales = LocaleFactory::create('place', $place->locales);

                return new PlaceQueryResponse($place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code);

            }

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

        $place = Place::createPlace($body->url, $placeLocales, $body->latitude, $body->longitude, $body->country_code, $body->status, $body->searchable);

        if( $place !== false ) {

            return new PlaceAdminResponse( $place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code, $place->status, $place->searchable, $place->create_time );

        } else {
            throw new BadRequestException('Place does already exist');
        }

    }

    /**
     * @param $place_id
     * @return PlaceAdminResponse
     * @throws ItemNotFoundException
     */
    public function updateAction($place_id)
    {

        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            // Get body
            $body = $this->request->getJsonRawBody();

            // Create locales
            $placeLocales           = LocaleFactory::create('place', $body->locales);
            
            $place->url             = $body->url;
            $place->country_code    = $body->country_code;
            $place->latitude        = $body->latitude;
            $place->longitude       = $body->longitude;
            $place->locales         = json_encode($placeLocales);
            $place->status          = $body->status;

            if ($place->searchable !== (bool)$body->searchable) {

                $place->searchable = (bool) $body->searchable;

                if( $body->searchable === true ) {

                    $searchTerm = SearchTermFactory::factory( $place->place_id, 'place' );
                    $searchTerm->create();

                } else {

                    // Delete terms
                    SearchTerm::deleteSearchTerm( $place->url );

                }

            }

            $place->save();

            return new PlaceAdminResponse( $place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code, $place->status, $place->searchable, $place->create_time );
        }

        throw new ItemNotFoundException('Could not find specified place');

    }

    /**
     * @return PlacesResponse
     * @throws ItemNotFoundException
     */
    public function queryAction()
    {

        $result = array();

        $tags = explode(' ',$this->request->getQuery('tags'));
        $url = $this->request->getQuery('url');

        foreach($tags as $tag) {
            $result[$tag] = Tag::factory('RodinAPI\Models\Tags')->where('tag_id', '=', $tag )->where('belongs_to', '^', 'place_')->findMany();
        }

        $i = 0;
        $intersect = array();

        foreach($result as $tag => $places) {

            /**
             * @var Tag $place
             */
            foreach($places as $place) {
                $intersect[$i][$place->belongs_to] = str_replace('place_', '', $place->belongs_to);
            }

            $i++;

        }

        if( count($intersect) == 1 ) {
            $matches = $intersect[0];
        } elseif( count($intersect) == 2 ) {
            $matches = array_intersect_key($intersect[0], $intersect[1]);
        } elseif( count($intersect) == 3 ) {
            $matches = array_intersect_key($intersect[0], $intersect[1], $intersect[2]);
        } elseif( count($intersect) == 4 ) {
            $matches = array_intersect_key($intersect[0], $intersect[1], $intersect[2], $intersect[3]);
        } else {
            throw new ItemNotFoundException('No places found');
        }

        $responseArray = new PlacesResponse();

        if( !empty($matches) ) {

            $places = Place::factory('RodinAPI\Models\Place')->batchGetItems($matches);

            /**
             * @var Place $place
             */
            foreach ($places as $place) {

                $locales = LocaleFactory::create('place', $place->locales);

                $response = new PlaceQueryResponse($place->place_id, $place->url, $locales, $place->latitude, $place->longitude, $place->country_code);
                $responseArray->addResponse($response);

            }

        }

        return $responseArray;

    }


}
