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
    public $info;

    /**
     * TagResponse constructor.
     * @param $tag_id
     * @param $category
     * @param $info
     */
    public function __construct($tag_id, $category, $info)
    {
        $this->tag_id   = $tag_id;
        $this->category = $category;
        $this->info     = $info;

        parent::__construct();
    }

}