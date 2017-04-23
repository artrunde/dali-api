<?php

namespace RodinAPI\Controllers;


use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\Place;
use RodinAPI\Models\Tag;
use RodinAPI\Response\Tags\TagArtistResponse;
use RodinAPI\Response\Tags\TagCityResponse;
use RodinAPI\Response\Tags\TagResponse;
use RodinAPI\Response\Tags\TagsResponse;


class TagsController extends BaseController
{

    public function createRelationAction($place_id) {

        // try by url first
        $place = Place::factory('RodinAPI\Models\Place')->findOne($place_id);

        if( !empty($place) ) {

            $cities     = new TagsResponse();
            $artists    = new TagsResponse();

            // Get body
            $body = $this->request->getJsonRawBody();

            foreach($body->cities as $city ) {

                Tag::createTagRelation($place_id, $city->city_id);

                $cityRelation = new TagCityResponse($city->city_id);
                $cities->addResponse($cityRelation);

            }

            foreach($body->artists as $artist ) {

                Tag::createTagRelation($place_id, $artist->artist_id);

                $artistRelation = new TagArtistResponse($artist->artist_id);
                $artists->addResponse($artistRelation);

            }

            return new TagResponse($cities, $artists);

        }

        throw new ItemNotFoundException('Could not find specified place');

    }

}
