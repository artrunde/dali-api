<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Factories\LocaleFactory;
use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Models\Artist;
use RodinAPI\Models\SearchTerm;
use RodinAPI\Response\Artists\ArtistDeleteResponse;
use RodinAPI\Response\Artists\ArtistResponse;

class ArtistsController extends BaseController
{

    public function deleteAction($artist_id)
    {

        $artists = Artist::factory('RodinAPI\Models\Artist')->where('tag_id','=',$artist_id)->findMany();

        foreach( $artists as $artist ) {

            $deleted = Artist::factory('RodinAPI\Models\Artist')->findOne($artist->tag_id, $artist->belongs_to)->delete();

            // Delete terms as well
            SearchTerm::deleteSearchTerm($artist->tag_id);
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

            // Create locales
            $artistLocales = LocaleFactory::create(Artist::getCategory(), $artist->locales);

            return new ArtistResponse( $artist->tag_id, $artistLocales, $artist->born_date, $artist->status, $artist->searchable );
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

        // Create locales
        $artistLocales = LocaleFactory::create(Artist::getCategory(), $body->locales);

        $artist = Artist::createArtistTag( $artistLocales, $body->born_date, $body->status, $body->searchable );

        if( $artist !== false ) {

            return new ArtistResponse( $artist->tag_id, $artistLocales, $artist->born_date, $artist->status, $artist->searchable );

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

            // Create locales
            $artistLocales = LocaleFactory::create(Artist::getCategory(), $body->locales);

            $artist->born_date = $body->born_date;
            $artist->status = $body->status;
            $artist->locales = json_encode($artistLocales);

            if ($artist->searchable !== (bool)$body->searchable) {

                $artist->searchable = (bool) $body->searchable;

                if( $body->searchable === true ) {

                    $searchTerm = SearchTermFactory::factory( $artist->tag_id, 'artist' );
                    $searchTerm->create();

                } else {

                    // Delete terms
                    SearchTerm::deleteSearchTerm( $artist->tag_id );

                }
            }

            $artist->save();

            return new ArtistResponse( $artist_id, $artistLocales, $artist->born_date, $artist->status, $artist->searchable );
        }

        throw new ItemNotFoundException('Could not find specified city');

    }


}
