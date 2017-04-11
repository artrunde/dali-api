<?php
namespace RodinAPI\Response;

class TagDeleteResponse extends Response
{

    /**
     * @var string
     */
    public $tag_id;

    /**
     * TagDeleteResponse constructor.
     * @param $tag_id
     */
    public function __construct( $tag_id )
    {
        $this->tag_id = $tag_id;

        parent::__construct();
    }

}