<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class Tag extends ODM {

    public $tag_id;

    public $belongs_to;

    public $category;

    public $create_time;

    protected $_table_name = 'rodin_tags_v1';

    protected $_hash_key = 'tag_id';

    protected $_range_key = 'belongs_to';

    protected $_schema = array(
        'tag_id'        => 'S',
        'belongs_to'    => 'S',
        'category'      => 'S',
        'create_time'   => 'S'
    );

}