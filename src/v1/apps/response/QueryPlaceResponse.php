<?php

namespace RodinAPI\Response;

class QueryPlaceResponse extends Response
{
    /**
     * @var string
     */
    public $place_id = null;

    /**
     * @var string
     */
    public $tag_id = null;

    /**
     * QueryPlaceResponse constructor.
     * @param $place_id
     * @param $tag_id
     */
    public function __construct($place_id, $tag_id)
    {
        $this->place_id = $place_id;
        $this->tag_id   = $tag_id;

        parent::__construct();
    }
}