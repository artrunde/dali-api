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
     * @param TagCategoryResponse $category
     * @param TagLabelsResponse|null $labels
     */
    public function __construct( $tag_id, TagCategoryResponse $category, TagLabelsResponse $labels = null )
    {
        $this->tag_id       = $tag_id;
        $this->category     = $category;
        $this->labels       = $labels;

        parent::__construct();
    }

}