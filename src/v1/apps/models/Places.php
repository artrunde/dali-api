<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class Places extends ODM {

	public $place_id;

	public $url_id;

	protected $_table_name = 'rodin_places_v1';

	protected $_hash_key   = 'place_id';

	protected $_schema = array(
		'place_id'   => 'S',
		'url_id'     => 'S'
	);

}