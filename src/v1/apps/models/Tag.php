<?php

namespace RodinAPI\Models;

use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Library\ODM;

class Tag extends ODM {

    public $tag_id;

    public $belongs_to;

    public $create_time;

    protected $_table_name = 'rodin_tags_v1';

    protected $_hash_key = 'tag_id';

    protected $_range_key = 'belongs_to';

    protected $_schema = array(
        'tag_id'        => 'S',
        'belongs_to'    => 'S',
        'create_time'   => 'S'
    );

    /**
     * @param $place_id
     * @param $tag_id
     * @return $this
     */
    public static function createTagRelation($place_id, $tag_id)
    {

        $tagRelation = Tag::factory('RodinAPI\Models\Tag')->create();

        $tagRelation->tag_id        = $tag_id;
        $tagRelation->belongs_to    = 'place_'.$place_id;
        $tagRelation->create_time   = date('c');

        $tagRelation->save();

        return $tagRelation;

    }

}