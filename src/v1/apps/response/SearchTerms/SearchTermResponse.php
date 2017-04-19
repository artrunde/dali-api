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
     * @var string
     */
    public $query;

    /**
     * @var string
     */
    public $locale;

    /**
     * @var string
     */
    public $label;

    /**
     * SearchTermResponse constructor.
     * @param $query
     * @param $locale
     * @param $tag_id
     * @param $label
     */
    public function __construct( $query, $locale, $tag_id, $label )
    {
        $this->query    = (string) $query;
        $this->locale   = (string) $locale;
        $this->tag_id   = (string) $tag_id;
        $this->label    = (string) $label;

        parent::__construct();
    }

}