<?php
namespace RodinAPI\Response\SearchTerms;

use RodinAPI\Response\Response;

class SearchTermResponse extends Response
{

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $belongs_to;

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
     * @param $type
     * @param $query
     * @param $locale
     * @param $belongs_to
     * @param $label
     */
    public function __construct( $type, $query, $locale, $belongs_to, $label )
    {
        $this->type         = (string) $type;
        $this->query        = (string) $query;
        $this->locale       = (string) $locale;
        $this->belongs_to   = (string) $belongs_to;
        $this->label        = (string) $label;

        parent::__construct();
    }

}