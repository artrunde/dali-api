<?php

namespace DaliAPI\Models;

use DaliAPI\Library\ODM;

class Tags extends ODM {

	public $tag_id;

	public $place_id;

	public $category;

	protected $_table_name = 'Tags';

	protected $_hash_key   = 'tag_id';

    protected $_range_key  = 'place_id';

	protected $_schema = array(
		'tag_id'    => 'S',    // search_term is number
		'place_id'  => 'S',    // type is string
		'category'  => 'S'
	);

}