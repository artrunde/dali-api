<?php
namespace RodinAPI\Response\Tags;

use RodinAPI\Response\Response;

class TagArtistResponse extends Response
{

    /**
     * @var string
     */
    public $artist_id;

    /**
     * TagArtistResponse constructor.
     * @param $artist_id
     */
    public function __construct( $artist_id )
    {
        $this->artist_id  = (string) $artist_id;

        parent::__construct();
    }

}