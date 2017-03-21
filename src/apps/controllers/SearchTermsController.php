<?php

namespace DaliAPI\Controllers;

use DaliAPI\Models\SearchTerms;
use DaliAPI\Response\SearchTermResponse;
use DaliAPI\Response\SearchTermsResponse;
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
            ->limit(10)
            ->findMany();


       $response = new SearchTermsResponse();

        /**
         * @var SearchTerms $searchTerm
         */
       foreach( $searchTerms as $searchTerm ) {

           $searchTermResponse = new SearchTermResponse($searchTerm->search_term_id, $searchTerm->tag_priority_id, $searchTerm->category, $searchTerm->tag_id);

           $response->addResponse($searchTermResponse);
       }

       return $response;

	}

}
