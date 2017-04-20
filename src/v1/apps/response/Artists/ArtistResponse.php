<?php
namespace RodinAPI\Response\Artists;

use RodinAPI\Models\LocaleTypes;
use RodinAPI\Response\Response;

class ArtistResponse extends Response
{

    /**
     * @var string
     */
    public $artist_id;


    /**
     * @var LocaleTypes
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
     * @param LocaleTypes $artistLocales
     * @param $born_date
     * @param $status
     * @param $searchable
     */
    public function __construct( $artist_id, LocaleTypes $artistLocales, $born_date, $status, $searchable )
    {
        $this->artist_id   = (string) $artist_id;
        $this->locales     = $artistLocales;
        $this->born_date   = (string) $born_date;
        $this->status      = (string) $status;
        $this->searchable  = (bool) $searchable;

        parent::__construct();
    }

}