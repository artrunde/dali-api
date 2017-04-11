<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\TagCategories;
use RodinAPI\Models\TagLabels;
use RodinAPI\Models\Tags;
use RodinAPI\Response\TagCategoryResponse;
use RodinAPI\Response\TagDeleteResponse;
use RodinAPI\Response\TagLabelResponse;
use RodinAPI\Response\TagLabelsResponse;
use RodinAPI\Response\TagResponse;;

class TagsController extends BaseController
{

    /**
     * @param $tag_id
     * @return TagResponse
     * @throws ItemNotFoundException
     */
    public function getTagAction($tag_id)
    {

        $tags = Tags::factory('RodinAPI\Models\Tags')
            ->where('tag_id','=', $tag_id)
            ->findMany();

        if( !empty($tags) ) {

            $labelsResponse = new TagLabelsResponse();

            if( !empty($tags) ) {

                foreach ($tags as $tag) {

                    $category = Tags::getCategoryFromTagId($tag_id);

                    if( TagLabels::validLocale($tag->belongs_to) ) {
                        $labelResponse      = new TagLabelResponse($category, $tag->belongs_to, $tag->label);
                        $labelsResponse->addResponse($labelResponse);
                    }

                }

                return new TagResponse( $tag_id, $category, $labelsResponse  );

            }

        }

        throw new ItemNotFoundException('Could not find specified tag');

    }

    public function getLabelAction($tag_id, $locale)
    {

        $tag = Tags::factory('RodinAPI\Models\Tags')->findOne($tag_id, $locale);

        if( !empty($tag) ) {

            if( TagLabels::validLocale($locale) ) {
                return new TagLabelResponse($locale, $tag->label);
            }

        }

        throw new ItemNotFoundException('Could not find specified label');

    }

    public function deleteTagAction($tag_id)
    {

        $tags = Tags::factory('RodinAPI\Models\Tags')->where('tag_id','=',$tag_id)->findMany();

        foreach( $tags as $tag ) {
            $tagDeleted = Tags::factory('RodinAPI\Models\Tags')->findOne($tag->tag_id, $tag->belongs_to)->delete();
        }

        if( !empty($tagDeleted) ) {
            return new TagDeleteResponse($tag_id);
        }

        throw new ItemNotFoundException('Could not find specified tag');

    }

    /**
     * @return TagResponse
     * @throws BadRequestException
     */
    public function createTagAction()
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        $tag = Tags::createTagNoLabels( $body->category );

        if( $tag !== false ) {

            // Create labels
            if( !empty($body->labels) ) {

                $tagLabelsResponse = $this->createLabel($tag->tag_id, $body->labels);

                return new TagResponse( $tag->tag_id, $body->category, $tagLabelsResponse );

            } else {

                return new TagResponse( $tag->tag_id, $body->category );

            }

        } else {
            throw new BadRequestException('Tag does already exist for this locale');
        }

    }

    /**
     * @param $tag_id
     * @param $locale
     * @return TagLabelResponse
     * @throws BadRequestException
     */
    public function createLabelAction($tag_id, $locale) {

        $body = $this->request->getJsonRawBody();

        $tagLabel = Tags::createLabel( $tag_id, $locale, $body->label );

        if ($tagLabel !== false) {

            return new TagLabelResponse($locale, $body->label);

        } else {
            throw new BadRequestException('Tag does already exist for this locale');
        }

    }

    /**
     * @param $tag_id
     * @param $labels
     * @return TagLabelsResponse
     * @throws BadRequestException
     */
    protected function createLabel($tag_id, $labels) {

        $tagLabelsResponse = new TagLabelsResponse();

        // Create labels
        if( !empty($labels) ) {

            foreach ( $labels as $label ) {

                $tagLabel = Tags::createLabel( $tag_id, $label->locale, $label->label );

                if ($tagLabel !== false) {

                    $tagLabelResponse =  new TagLabelResponse(Tags::getCategoryFromTagId($tag_id), $label->locale, $label->label);

                    $tagLabelsResponse->addResponse($tagLabelResponse);

                }

            }

        }

        return $tagLabelsResponse;

    }

}
