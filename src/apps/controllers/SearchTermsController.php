<?php

namespace RodinAPI\Controllers;

use RodinAPI\Models\SearchTerms;
use RodinAPI\Response\SearchTermResponse;
use RodinAPI\Response\SearchTermsResponse;

class SearchTermsController extends BaseController
{

    public function searchAction($searchTerm)
	{
        /**
         * @var SearchTerms $searchTerms
         */
       $searchTerms = SearchTerms::factory('RodinAPI\Models\SearchTerms')
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
