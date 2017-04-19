<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Models\Artist;
use RodinAPI\Models\SearchTerm;
use RodinAPI\Response\Artists\ArtistDeleteResponse;
use RodinAPI\Response\Artists\ArtistResponse;
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

        foreach ($searchTerms as $searchTerm) {

            $response = new SearchTermResponse($query, $locale, $searchTerm->tag_id, $searchTerm->label);
            $responseArray->addResponse($response);

        }

        return $responseArray;

    }

}
