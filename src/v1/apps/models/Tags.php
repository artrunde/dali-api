<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class Tags extends ODM {

	public $tag_id;

	public $belongs_to;

	public $label;

    public $create_time;

	protected $_table_name = 'rodin_tags_v1';

	protected $_hash_key = 'tag_id';

    protected $_range_key = 'belongs_to';

	protected $_schema = array(
		'tag_id'        => 'S',
		'belongs_to'    => 'S',
        'label'         => 'S',
        'create_time'   => 'S'
	);

}