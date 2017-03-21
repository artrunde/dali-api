<?php

namespace DaliAPI\Controllers;

use DaliAPI\Models\SearchTerms;
use Phalcon\Mvc\Controller;

class SearchTermsController extends Controller
{

    public function searchAction($searchTerm)
	{
        /**
         * @var SearchTerms $searchTerms
         */
       $searchTerms = SearchTerms::factory('DaliAPI\Models\SearchTerms')
            ->where('search_term_id', '=', $searchTerm)
            ->limit(3)
            ->findMany();

        $this->response->setJsonContent($searchTerms);
		$this->response->send();

	}

    public function queryAction($searchTerm)
    {
        /**
         * @var SearchTerms $searchTerms
         */
        $searchTerms = SearchTerms::factory('DaliAPI\Models\SearchTerms')
            ->where('search_term_id', '=', $searchTerm)
            ->limit(3)
            ->findMany();

        $this->response->setJsonContent($searchTerms);
        $this->response->send();

    }
}
