<?php
namespace RodinAPI\Response;

class TagLabelResponse extends Response
{
    /**
     * @var string
     */
    public $locale;

    /**
     * @var string
     */
    public $label;

    /**
     * TagLabelResponse constructor.
     * @param $category
     * @param $locale
     * @param $label
     */
    public function __construct($locale, $label)
    {
        $this->locale   = $locale;
        $this->label    = $label;

        parent::__construct();
    }

}