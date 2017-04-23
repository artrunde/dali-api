<?php

namespace RodinAPI\Controllers;

use RodinAPI\Models\SearchTerm;
use RodinAPI\Response\SearchTerms\SearchTermResponse;
use RodinAPI\Response\SearchTerms\SearchTermsResponse;

class SearchTermsController extends BaseController
{

    /**
     * @return SearchTermsResponse
     */
    public function queryAction()
    {

        $query  = $this->request->getQuery('query');
        $locale = $this->request->getQuery('locale');

        $searchTerms = SearchTerm::factory('RodinAPI\Models\SearchTerm')->where('search_term', '=', $locale . '_' . $query)->findMany();

        $responseArray = new SearchTermsResponse();

        /**
         * @var SearchTerm $searchTerm
         */
        foreach ($searchTerms as $searchTerm) {

            $response = new SearchTermResponse($searchTerm->getType(), $query, $locale, $searchTerm->belongs_to, $searchTerm->getLabel());
            $responseArray->addResponse($response);

        }

        return $responseArray;

    }

}
