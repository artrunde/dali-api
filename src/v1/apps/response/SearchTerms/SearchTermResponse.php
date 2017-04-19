<?php
namespace RodinAPI\Response\SearchTerms;

use RodinAPI\Response\Response;

class SearchTermResponse extends Response
{

    /**
     * @var string
     */
    public $tag_id;

    /**
     * ArtistResponse constructor.
     * @param $tag_id
     */
    public function __construct( $tag_id )
    {
        $this->tag_id = (string) $tag_id;

        parent::__construct();
    }

}