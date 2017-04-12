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


    public function __construct( $artist_id, $locales, $born_date, $status )
    {
        $this->artist_id   = (string) $artist_id;
        $this->locales     = json_decode($locales);
        $this->born_date   = (string) $born_date;
        $this->status      = (string) $status;

        parent::__construct();
    }

}