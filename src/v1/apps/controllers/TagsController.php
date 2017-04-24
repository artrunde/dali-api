<?php

namespace RodinAPI\Controllers;


use RodinAPI\Exceptions\InternalErrorException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Factories\LocaleFactory;
use RodinAPI\Models\Artist;
use RodinAPI\Models\City;
use RodinAPI\Models\Place;
use RodinAPI\Models\Tag;
use RodinAPI\Response\Artists\ArtistResponse;
use RodinAPI\Response\Cities\CityResponse;
use RodinAPI\Response\Tags\TagResponse;
use RodinAPI\Response\Tags\TagsResponse;


class TagsController extends BaseController
{

    public function getRelationsAction($place_id) {

        // try by url first
        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            $cities     = new TagsResponse();
            $artists    = new TagsResponse();

            // try by url first
            $relations = Tag::factory('RodinAPI\Models\Tag')->where('belongs_to','=','place_'.$place_id)->index('BelongsToTagIndex')->findMany();

            foreach($relations as $relation) {

                switch ( $relation->category ){

                    case City::getCategory():

                        $city = City::factory('RodinAPI\Models\City')->findOne($relation->tag_id, City::CATEGORY);

                        $cityLocales = LocaleFactory::create('city', $city->locales);

                        $cityRelation = new CityResponse( $city->tag_id, $city->country_code, $city->latitude, $city->longitude, $cityLocales, $city->searchable );
                        $cities->addResponse($cityRelation);

                        break;

                    case Artist::getCategory():

                        $artist = Artist::factory('RodinAPI\Models\Artist')->findOne($relation->tag_id, Artist::CATEGORY);

                        $artistLocales = LocaleFactory::create('artist', $artist->locales);

                        $artistRelation = new ArtistResponse( $artist->tag_id, $artistLocales, $artist->born_date, $artist->status, $artist->searchable );
                        $artists->addResponse($artistRelation);

                        break;

                    default:

                        throw new InternalErrorException('Unknown category in relations');

                }
            }

            return new TagResponse($cities, $artists);

        }

        throw new ItemNotFoundException('Could not find specified place');

    }

    public function createRelationAction($place_id) {

        // try by url first
        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            $cities     = new TagsResponse();
            $artists    = new TagsResponse();

            // Get body
            $body = $this->request->getJsonRawBody();

            foreach( $body->cities as $cityTag ) {

                $city = City::createTagRelation($place_id, $cityTag->city_id);

                $cityLocales = LocaleFactory::create('city', $city->locales);

                $cityRelation = new CityResponse( $city->tag_id, $city->country_code, $city->latitude, $city->longitude, $cityLocales, $city->searchable );
                $cities->addResponse($cityRelation);

            }

            foreach( $body->artists as $artistTag ) {

                $artist = Artist::createTagRelation($place_id, $artistTag->artist_id);

                $artistLocales = LocaleFactory::create('artist', $artist->locales);

                $artistRelation = new ArtistResponse( $artist->tag_id, $artistLocales, $artist->born_date, $artist->status, $artist->searchable );
                $artists->addResponse($artistRelation);

            }

            return new TagResponse($cities, $artists);

        }

        throw new ItemNotFoundException('Could not find specified place');

    }

}
