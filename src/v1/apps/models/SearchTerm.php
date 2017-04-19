<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class SearchTerm extends ODM {

	public $search_term;

	public $label;

    public $tag_id;

    public $create_time;

	protected $_table_name = 'rodin_search_terms_v1';

	protected $_hash_key = 'search_term';

    protected $_range_key = 'label';

	protected $_schema = array(
        'search_term'   => 'S',
        'label'         => 'S',
        'tag_id'        => 'S',
        'create_time'   => 'S'
	);

    /**
     * @param $search_term
     * @param $label
     * @param $tag_id
     * @return $this
     */
    public static function createSearchTerm( $search_term, $label, $tag_id )
    {

        $searchTerm = SearchTerm::factory('RodinAPI\Models\SearchTerm')->create();

        $searchTerm->search_term    = strtolower($search_term);
        $searchTerm->label          = $label;
        $searchTerm->tag_id         = $tag_id;
        $searchTerm->create_time    = date('c');

        $searchTerm->save();

        return $searchTerm;
    }

    public static function deleteSearchTerm($tag_id)
    {

        $terms = SearchTerm::factory('RodinAPI\Models\SearchTerm')->where('tag_id','=',$tag_id)->index('TagSearchTermIndex')->findMany();

        foreach( $terms as $term ) {
            $deleted = SearchTerm::factory('RodinAPI\Models\SearchTerm')->findOne($term->search_term, $term->label)->delete();
        }

        return $deleted;

    }

}