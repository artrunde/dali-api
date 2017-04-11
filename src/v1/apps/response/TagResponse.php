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
     * @var string
     */
    public $labels;

    /**
     * TagResponse constructor.
     * @param $tag_id
     * @param $category
     * @param TagLabelsResponse|null $labels
     */
    public function __construct( $tag_id, $category, TagLabelsResponse $labels = null )
    {
        $this->tag_id       = $tag_id;
        $this->category     = $category;
        $this->labels       = $labels === null ? array() : $labels;

        parent::__construct();
    }

}