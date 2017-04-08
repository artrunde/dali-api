<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\SearchTerms;
use RodinAPI\Models\Tags;
use RodinAPI\Response\TagResponse;
use RodinAPI\Response\TagsResponse;

class SearchTermsController extends BaseController
{

	public function searchAction()
	{

	    // Get all tags
        $query      = $this->request->getQuery('query');
        $category   = $this->request->getQuery('category');
        $locale     = $this->request->getQuery('locale');
        $limit      = $this->request->getQuery('limit');

        $search_terms = SearchTerms::factory('RodinAPI\Models\SearchTerms')
            ->where('search_term', '', $locale.'_'.$query)
            ->findMany();

        $searchResult = array();

        foreach ($search_terms as $search_term) {
            $searchResult[] = array($search_term->tag_id, $locale);
        }

        if( count($searchResult) > 0 ) {

            /**
             * Slice array with limit.
             */
            if (count($searchResult) > $limit) {
                $searchResult = array_slice($searchResult, 0, $limit);
            }

            $tags = Tags::factory('RodinAPI\Models\Tags')->batchGetItems($searchResult);

            if (!empty($category)) {
                // Parse category
                $category = explode(',', $category);
            }

            // Check query param
            if (!empty($query) || !empty($category)) {

                $responseArray = new TagsResponse();

                foreach ($tags as $tag) {

                    $exploded = explode('_', $tag->tag_id);

                    $response = new TagResponse($exploded[1], $exploded[0], $tag->belongs_to, $tag->label);

                    $responseArray->addResponse($response);
                }

                return $responseArray;

            } else {
                throw new BadRequestException('Invalid query');
            }

        } else {
            throw new ItemNotFoundException('No tags found');
        }

	}

}
