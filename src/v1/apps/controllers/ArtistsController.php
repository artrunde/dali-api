<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\Artist;
use RodinAPI\Response\Artists\ArtistDeleteResponse;
use RodinAPI\Response\Artists\ArtistResponse;

class ArtistsController extends BaseController
{

    public function deleteAction($artist_id)
    {

        $artists = Artist::factory('RodinAPI\Models\Artist')->where('tag_id','=',$artist_id)->findMany();

        foreach( $artists as $artist ) {
            $deleted = Artist::factory('RodinAPI\Models\Artist')->findOne($artist->tag_id, $artist->belongs_to)->delete();
        }

        if( !empty($deleted) ) {
            return new ArtistDeleteResponse($artist_id);
        }

        throw new ItemNotFoundException('Could not find specified artist');

    }


    /**
     * @param $city_id
     * @return ArtistResponse
     * @throws ItemNotFoundException
     */
    public function getAction($city_id)
    {

        $artist = Artist::factory('RodinAPI\Models\Artist')->findOne($city_id, Artist::CATEGORY);

        if( !empty($artist) ) {
            return new ArtistResponse( $artist->tag_id, $artist->locales, $artist->born_date, $artist->status );
        }

        throw new ItemNotFoundException('Could not find specified artist');

    }

    /**
     * @return ArtistResponse
     * @throws BadRequestException
     */
    public function createAction()
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        $artist = Artist::createArtistTag( $body->locales, $body->born_date, $body->status );

        if( $artist !== false ) {

            return new ArtistResponse( $artist->tag_id, $artist->locales, $artist->born_date, $artist->status );

        } else {
            throw new BadRequestException('Artist does already exist');
        }

    }

    /**
     * @param $artist_id
     * @return ArtistResponse
     * @throws ItemNotFoundException
     */
    public function updateAction($artist_id)
    {

        $artist = Artist::factory('RodinAPI\Models\Artist')->findOne($artist_id, Artist::CATEGORY);

        if( !empty($artist) ) {

            // Get body
            $body = $this->request->getJsonRawBody();

            $artist->born_date    = $body->born_date;
            $artist->status       = $body->status;
            $artist->locales      = json_encode($body->locales);

            $artist->save();

            return new ArtistResponse( $artist_id, $artist->locales, $artist->born_date, $artist->status  );
        }

        throw new ItemNotFoundException('Could not find specified city');

    }


}
