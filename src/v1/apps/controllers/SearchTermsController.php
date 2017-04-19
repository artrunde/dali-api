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
     * @return SearchTermResponse
     */
    public function createAction()
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        $searchTerm = SearchTermFactory::factory( $body->tag_id );
        $searchTerm->create();

        return new SearchTermResponse($body->tag_id);

    }

    public function deleteAction($tag_id)
    {

        $searchTerms = SearchTerm::factory('RodinAPI\Models\SearchTerm')->where('tag_id','=',$tag_id)->index('TagSearchTermIndex')->findMany();

        foreach( $searchTerms as $searchTerm ) {
            $deleted = SearchTerm::factory('RodinAPI\Models\SearchTerm')->findOne($searchTerm->search_term, $searchTerm->label)->delete();
        }

        if( !empty($deleted) ) {
            return new ArtistDeleteResponse($tag_id);
        }

        throw new ItemNotFoundException('Could not find specified search term');

    }

}
