<?php
namespace RodinAPI\Response\Tags;

use RodinAPI\Response\Response;

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
        $this->tag_id = (string) $tag_id;

        parent::__construct();
    }

}