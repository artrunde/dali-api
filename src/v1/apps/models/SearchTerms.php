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

	public static function createSearchTermsForTag( Tags $tag, $priority = 1 ) {

        $string = $tag->label;
        $label  = $string;
        $length = strlen($label);

        $searchTerm = SearchTerms::factory('RodinAPI\Models\SearchTerms')->create();

        for ( $i = 3; $i <= $length; $i++  ) {

            try {

                $searchTerm->search_term    = $tag->belongs_to.'_'.substr($label, 0, $i);
                $searchTerm->tag_id         = $tag->tag_id;
                $searchTerm->priority       = $priority;

                $searchTerm->save();

            } catch (\Exception $e) {
                var_dump($e);die;
            }

        }

        return true;

    }

}