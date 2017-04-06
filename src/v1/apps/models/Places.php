<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class Places extends ODM {

	public $place_id;

	public $url_path;

	public $name;

    public $address;

    public $vat_number;

    public $create_time;

	protected $_table_name = 'rodin_places_v1';

	protected $_hash_key   = 'place_id';

	protected $_schema = array(
        'place_id'      => 'S',
        'url_path'      => 'S',
        'name'          => 'S',
        'address'       => 'S',
        'vat_number'    => 'S',
        'create_time'   => 'S'
	);

}