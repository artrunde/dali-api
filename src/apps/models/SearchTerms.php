<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class SearchTerms extends ODM {

	public $search_term_id;

	public $tag_priority_id;

	public $category;

    public $tag_id;

	protected $_table_name = 'rodin_search_terms_v1';

	protected $_hash_key   = 'search_term_id';

    protected $_range_key  = 'tag_priority_id';

	protected $_schema = array(
		'search_term_id'   => 'S',    // search_term is number
		'tag_priority_id'  => 'S',    // type is string
		'category'         => 'S',
        'tag_id'           => 'S'
	);

}