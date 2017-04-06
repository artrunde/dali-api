<?php

namespace RodinAPI\Response;

class PlaceResponse extends Response
{

    /**
     * @var string
     */
    public $place_id;

    /**
     * @var string
     */
    public $url_path;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $vat_number;

    /**
     * @var string
     */
    public $create_time;

    /**
     * PlaceResponse constructor.
     * @param $place_id
     * @param $url_path
     * @param $name
     * @param $address
     * @param $vat_number
     * @param $create_time
     */
    public function __construct($place_id, $url_path, $name, $address, $vat_number, $create_time)
    {
        $this->place_id     = $place_id;
        $this->url_path     = $url_path;
        $this->name         = $name;
        $this->address      = $address;
        $this->vat_number   = $vat_number;
        $this->create_time  = $create_time;

        parent::__construct();
    }

}