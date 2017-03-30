<?php

namespace RodinAPI\Response;

class PlaceResponse extends Response
{
    /**
     * @var string
     */
    public $place_id = null;

    /**
     * @var string
     */
    public $url_id = null;

    /**
     * QueryPlaceResponse constructor.
     * @param $place_id
     * @param $url_id
     */
    public function __construct($place_id, $url_id)
    {
        $this->place_id = $place_id;
        $this->url_id   = $url_id;

        parent::__construct();
    }
}