<?php
namespace RodinAPI\Response\Artists;

use RodinAPI\Response\Response;

class ArtistDeleteResponse extends Response
{

    /**
     * @var string
     */
    public $artist_id;

    /**
     * ArtistDeleteResponse constructor.
     * @param $artist_id
     */
    public function __construct( $artist_id )
    {
        $this->artist_id   = (string) $artist_id;

        parent::__construct();
    }

}