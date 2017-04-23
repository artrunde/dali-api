<?php
namespace RodinAPI\Response\Places;

use RodinAPI\Response\Response;

class PlaceDeleteResponse extends Response
{

    /**
     * @var string
     */
    public $place_id;

    /**
     * PlaceDeleteResponse constructor.
     * @param $place_id
     */
    public function __construct( $place_id )
    {
        $this->place_id = (string) $place_id;

        parent::__construct();
    }

}