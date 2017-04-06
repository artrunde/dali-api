<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class Tags extends ODM {

	public $tag_id;

	public $category;

	public $info;

    public $create_time;

	protected $_table_name = 'rodin_tags_v1';

	protected $_hash_key   = 'tag_id';

	protected $_schema = array(
		'tag_id'        => 'S',
		'category'      => 'S',
		'info'          => 'S',
        'create_time'   => 'S'
	);

}