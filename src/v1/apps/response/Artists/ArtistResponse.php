<?php
namespace RodinAPI\Response\Artists;

use RodinAPI\Response\Response;

class ArtistResponse extends Response
{

    /**
     * @var string
     */
    public $artist_id;


    /**
     * @var string
     */
    public $locales;

    /**
     * @var string
     */
    public $born_date;

    /**
     * @var string
     */
    public $status;

    /**
     * @var bool
     */
    public $searchable;


    /**
     * ArtistResponse constructor.
     * @param $artist_id
     * @param $locales
     * @param $born_date
     * @param $status
     * @param $searchable
     */
    public function __construct( $artist_id, $locales, $born_date, $status, $searchable )
    {
        $this->artist_id   = (string) $artist_id;
        $this->locales     = json_decode($locales);
        $this->born_date   = (string) $born_date;
        $this->status      = (string) $status;
        $this->searchable  = (bool) $searchable;

        parent::__construct();
    }

}