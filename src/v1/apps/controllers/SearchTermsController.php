<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Models\Tags;
use RodinAPI\Response\TagResponse;
use RodinAPI\Response\TagsResponse;

class SearchTermsController extends BaseController
{

	public function searchAction()
	{

        $query      = $this->request->getQuery('query');
        $category   = $this->request->getQuery('category');
        $locale     = $this->request->getQuery('locale');
        $limit      = $this->request->getQuery('limit');

        $locale = (empty($locale))? 'en' : $locale;
        $limit  = (empty($limit))? '10' : $limit;

        // TODO get these from search terms
	    $bulk = array (
            array('city_f6b6090ae5ac4681a7e3eead1cf9f9af', $locale),
            array('city_bfbba1b0046d4e3c955a741a8b4e1ab3', $locale),
            array('city_03356a88fafa43a289c6bf5c9cf51b89', $locale)
        );

        $tags = Tags::factory('RodinAPI\Models\Tags')->batchGetItems($bulk);

        if(!empty($category)) {
            // Parse category
            $category = explode(',',$category);
        }

	    // Check query param
        if( !empty($query) || !empty($category) ) {

            $responseArray = new TagsResponse();

            /**
             * Slice array with limit. TODO do this before bulk
             */
            if( count($tags) > $limit) {
                $tags = array_slice( $tags, 0, $limit );
            }

            foreach($tags as $tag) {

                $exploded = explode('_', $tag->tag_id);

                $response = new TagResponse($exploded[1], $exploded[0], $tag->belongs_to, $tag->label);

                $responseArray->addResponse($response);
            }

            return $responseArray;

        } else {
            throw new BadRequestException('Invalid query');
        }

	}

}
