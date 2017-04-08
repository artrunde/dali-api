<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class SearchTerms extends ODM {

	public $search_term;

	public $tag_id;

	public $priority;

    public $create_time;

	protected $_table_name = 'rodin_search_terms_v1';

	protected $_hash_key = 'search_term';

    protected $_range_key = 'tag_id';

	protected $_schema = array(
		'search_term'   => 'S',
        'tag_id'        => 'S',
        'priority'      => 'N',
        'create_time'   => 'S'
	);

}