<?php
namespace RodinAPI\Response;

class TagResponse extends Response
{

    /**
     * @var string
     */
    public $tag_id;

    /**
     * @var string
     */
    public $category;

    /**
     * @var
     */
    public $locale;

    /**
     * @var string
     */
    public $label;

    /**
     * TagResponse constructor.
     * @param $tag_id
     * @param $category
     * @param $locale
     * @param $label
     */
    public function __construct($tag_id, $category, $locale, $label)
    {
        $this->tag_id       = $tag_id;
        $this->category     = $category;
        $this->locale       = $locale;
        $this->label        = $label;

        parent::__construct();
    }

}