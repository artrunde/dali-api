<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Factories\LocaleFactory;
use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Models\Artist;
use RodinAPI\Models\City;
use RodinAPI\Models\Place;
use RodinAPI\Models\SearchTerm;
use RodinAPI\Models\Tag;
use RodinAPI\Response\Places\PlaceDeleteResponse;
use RodinAPI\Response\Places\PlaceAdminResponse;

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
     * @param $identifier
     * @return PlaceAdminResponse
     * @throws ItemNotFoundException
     */
    public function getAction($identifier)
    {

        // try by url first
        $place = Place::factory('RodinAPI\Models\Place')->where('url','=',$identifier)->index('urlIndex')->findFirst();

        if( !empty($place) ) {

            // Create locales
            $placeLocales = LocaleFactory::create('place', $place->locales);

            return new PlaceAdminResponse( $place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code, $place->status, $place->searchable, $place->create_time );

        } else {

            // try place_id second
            $place = Place::factory('RodinAPI\Models\Place')->findOne($identifier);

            if( !empty($place) ) {

                // Create locales
                $placeLocales = LocaleFactory::create('place', $place->locales);

                return new PlaceAdminResponse( $place->place_id, $place->url, $placeLocales, $place->latitude, $place->longitude, $place->country_code, $place->status, $place->searchable, $place->create_time );

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

                    $searchTerm = SearchTermFactory::factory( $place->url, 'place' );
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

    public function queryAction()
    {

        $tags = $this->request->getQuery('tag');
        $url = $this->request->getQuery('url');

        var_dump(explode(' ', $tag));
        var_dump($url);die;

        $searchTerms = SearchTerm::factory('RodinAPI\Models\SearchTerm')->where('search_term', '=', $locale . '_' . $query)->findMany();

        $responseArray = new SearchTermsResponse();

        /**
         * @var SearchTerm $searchTerm
         */
        foreach ($searchTerms as $searchTerm) {

            $response = new SearchTermResponse($searchTerm->getType(), $query, $locale, $searchTerm->belongs_to, $searchTerm->getLabel());
            $responseArray->addResponse($response);

        }

        return $responseArray;

    }


}
