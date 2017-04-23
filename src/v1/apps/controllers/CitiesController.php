<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Factories\LocaleFactory;
use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Models\City;
use RodinAPI\Models\SearchTerm;
use RodinAPI\Models\Tag;
use RodinAPI\Response\Cities\CityDeleteResponse;
use RodinAPI\Response\Cities\CityResponse;

class CitiesController extends BaseController
{

    public function deleteAction($city_id)
    {

        $cities = City::factory('RodinAPI\Models\City')->where('tag_id','=',$city_id)->findMany();

        foreach( $cities as $city ) {

            $deleted = City::factory('RodinAPI\Models\City')->findOne($city->tag_id, $city->belongs_to)->delete();

            // Delete terms as well
            SearchTerm::deleteSearchTerm($city->tag_id);

        }

        if( !empty($deleted) ) {
            return new CityDeleteResponse($city_id);
        }

        throw new ItemNotFoundException('Could not find specified city');

    }

    /**
     * @param $city_id
     * @return CityResponse
     * @throws ItemNotFoundException
     */
    public function getAction($city_id)
    {

        $city = City::factory('RodinAPI\Models\City')->findOne($city_id, City::CATEGORY);

        if( !empty($city) ) {

            // Create locales
            $cityLocales = LocaleFactory::create('city', $city->locales);

            return new CityResponse( $city_id, $city->country_code, $city->latitude, $city->longitude, $cityLocales, $city->searchable );
        }

        throw new ItemNotFoundException('Could not find specified city');

    }

    /**
     * @param $city_id
     * @return CityResponse
     * @throws ItemNotFoundException
     */
    public function updateAction($city_id)
    {

        $city = City::factory('RodinAPI\Models\City')->findOne($city_id, City::CATEGORY);

        if( !empty($city) ) {

            // Get body
            $body = $this->request->getJsonRawBody();

            // Create locales
            $cityLocales        = LocaleFactory::create('city', $body->locales);

            $city->country_code = $body->country_code;
            $city->latitude     = $body->latitude;
            $city->longitude    = $body->longitude;
            $city->locales      = json_encode($cityLocales);

            if ($city->searchable !== (bool)$body->searchable) {

                $city->searchable = (bool) $body->searchable;

                if( $body->searchable === true ) {

                    $searchTerm = SearchTermFactory::factory( $city->tag_id, 'city' );
                    $searchTerm->create();

                } else {

                    // Delete terms
                    SearchTerm::deleteSearchTerm( $city->tag_id );

                }

            }

            $city->save();

            return new CityResponse( $city_id, $city->country_code, $city->latitude, $city->longitude, $cityLocales, $city->searchable );
        }

        throw new ItemNotFoundException('Could not find specified city');

    }

    /**
     * @return CityResponse
     * @throws BadRequestException
     */
    public function createAction()
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        // Create locales
        $cityLocales = LocaleFactory::create('city', $body->locales);

        $city = City::createCityTag( $body->country_code, $body->latitude, $body->longitude, $cityLocales, $body->searchable );

        if( $city !== false ) {

            return new CityResponse( $city->tag_id, $city->country_code, $city->latitude, $city->longitude, $cityLocales, $city->searchable );

        } else {
            throw new BadRequestException('City does already exist');
        }

    }


}
