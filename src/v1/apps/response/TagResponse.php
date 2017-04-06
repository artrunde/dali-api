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
     * @var string
     */
    public $create_time;

    /**
     * TagResponse constructor.
     * @param $tag_id
     * @param $category
     * @param $info
     * @param $create_time
     */
    public function __construct($tag_id, $category, $info, $create_time)
    {
        $this->tag_id       = $tag_id;
        $this->category     = $category;
        $this->info         = $info;
        $this->create_time  = $create_time;

        parent::__construct();
    }

}