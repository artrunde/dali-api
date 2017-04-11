<?php
namespace RodinAPI\Response;

class TagLabelResponse extends Response
{

    /**
     * @var string
     */
    public $category;

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
    public function __construct($category, $locale, $label)
    {
        $this->category = $category;
        $this->locale   = $locale;
        $this->label    = $label;

        parent::__construct();
    }

}