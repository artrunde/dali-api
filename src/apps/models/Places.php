<?php

namespace DaliAPI\Models;

use DaliAPI\Library\ODM;

class Places extends ODM {

	public $place_id;

	public $url_id;

	protected $_table_name = 'tate_places';

	protected $_hash_key   = 'place_id';

	protected $_schema = array(
		'place_id'   => 'S',
		'url_id'     => 'S'
	);

}