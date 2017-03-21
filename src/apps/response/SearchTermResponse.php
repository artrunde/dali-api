<?php

namespace DaliAPI\Response;

class SearchTermResponse extends Response
{
    /**
     * @var string
     */
    public $search_term_id;

    /**
     * @var string
    */
    public $tag_priority_id;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $tag_id;

    /**
     * SearchTermResponse constructor.
     * @param $search_term_id
     * @param $tag_priority_id
     * @param $category
     * @param $tag_id
     */
    public function __construct($search_term_id, $tag_priority_id, $category, $tag_id)
    {
        $this->search_term_id   = $search_term_id;
        $this->tag_priority_id  = $tag_priority_id;
        $this->category         = $category;
        $this->tag_id           = $tag_id;

        parent::__construct();
    }

}