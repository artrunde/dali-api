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
use RodinAPI\Response\Tags\TagDeleteResponse;
use RodinAPI\Response\Tags\TagResponse;
use RodinAPI\Response\Tags\TagsResponse;


class TagsController extends BaseController
{

    /**
     * @param $place_id
     * @param $tag_id
     * @return TagDeleteResponse
     * @throws ItemNotFoundException
     */
    public function deleteRelationAction($place_id, $tag_id)
    {
        // Get place
        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            // Get relations
            $relation = Tag::factory('RodinAPI\Models\Tag')->where('belongs_to','=','place_'.$place_id)->where('tag_id','=', $tag_id)->index('BelongsToTagIndex')->findFirst();

            if( !empty($relation) ) {
                $relation->delete();
            }

            return new TagDeleteResponse($tag_id);

        }

        throw new ItemNotFoundException('Could not find specified place');
    }

    /**
     * @param $place_id
     * @return TagResponse
     * @throws InternalErrorException
     * @throws ItemNotFoundException
     */
    public function getRelationsAction($place_id) {

        // try by url first
        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            $cities     = new TagsResponse();
            $artists    = new TagsResponse();

            // Get relations
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

    /**
     * @param $place_id
     * @return TagResponse
     * @throws ItemNotFoundException
     */
    public function createRelationAction($place_id) {

        // try by url first
        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            $cities     = new TagsResponse();
            $artists    = new TagsResponse();

            // Get body
            $body = $this->request->getJsonRawBody();

            if ( !empty($body->cities ) ) {

                foreach ($body->cities as $cityTag) {

                    $city = City::createTagRelation($place_id, $cityTag->city_id);

                    $cityLocales = LocaleFactory::create('city', $city->locales);

                    $cityRelation = new CityResponse($city->tag_id, $city->country_code, $city->latitude, $city->longitude, $cityLocales, $city->searchable);
                    $cities->addResponse($cityRelation);

                }

            }

            if ( !empty($body->artists ) ) {

                foreach ($body->artists as $artistTag) {

                    $artist = Artist::createTagRelation($place_id, $artistTag->artist_id);

                    $artistLocales = LocaleFactory::create('artist', $artist->locales);

                    $artistRelation = new ArtistResponse($artist->tag_id, $artistLocales, $artist->born_date, $artist->status, $artist->searchable);
                    $artists->addResponse($artistRelation);

                }
            }

            return new TagResponse($cities, $artists);

        }

        throw new ItemNotFoundException('Could not find specified place');

    }

}
