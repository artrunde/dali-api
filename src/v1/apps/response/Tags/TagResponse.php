<?php
namespace RodinAPI\Response\Tags;

use RodinAPI\Response\Response;
use RodinAPI\Response\ResponseArray;

class TagResponse extends Response
{

    /**
     * @var ResponseArray
     */
    public $cities;

    /**
     * @var ResponseArray
     */
    public $artists;

    /**
     * TagResponse constructor.
     * @param ResponseArray $cities
     * @param ResponseArray $artists
     */
    public function __construct( ResponseArray $cities, ResponseArray $artists )
    {
        $this->cities         = $cities;
        $this->artists        = $artists;

        parent::__construct();
    }

}