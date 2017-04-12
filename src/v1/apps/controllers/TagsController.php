<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\TagCategories;
use RodinAPI\Models\TagLabels;
use RodinAPI\Models\Tags;
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

                $category = Tags::getCategoryFromMultipleTags($tags);

                // Find labels
                foreach ($tags as $tag) {

                    if( TagLabels::validLocale( TagLabels::getLocale($tag->belongs_to) ) ) {

                        $labelResponse = new TagLabelResponse(TagLabels::getLocale($tag->belongs_to), $tag->label);
                        $labelsResponse->addResponse($labelResponse);
                    }

                }

                return new TagResponse( $tag_id, $category, $labelsResponse  );

            }

        }

        throw new ItemNotFoundException('Could not find specified tag');

    }

    public function getAllLabelsAction($tag_id)
    {

        $tags = Tags::factory('RodinAPI\Models\Tags')->where('tag_id', '=', $tag_id)->findMany();

        $labelsResponse = new TagLabelsResponse();

        if( !empty($tags) ) {

            foreach ( $tags as $tag ) {

                if( strpos($tag->belongs_to, 'locale_') !== false ) {

                    $response = new TagLabelResponse(TagLabels::getLocale($tag->belongs_to), $tag->label);

                    $labelsResponse->addResponse($response);
                }

            }

        }

        return $labelsResponse;

    }

    /**
     * @param $tag_id
     * @param $locale
     * @return TagLabelResponse
     * @throws ItemNotFoundException
     */
    public function getLabelAction($tag_id, $locale)
    {

        $tag = Tags::factory('RodinAPI\Models\Tags')->findOne($tag_id, 'locale_'.$locale);

        if( !empty($tag) ) {

            return new TagLabelResponse(TagLabels::getLocale($tag->belongs_to), $tag->label);
        }

        throw new ItemNotFoundException('Label not found');

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

                $tagLabelsResponse = $this->createLabel($tag->tag_id, $body->category, $body->labels);

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
     * @param $category
     * @param $labels
     * @return TagLabelsResponse
     */
    protected function createLabel($tag_id, $category, $labels) {

        $tagLabelsResponse = new TagLabelsResponse();

        // Create labels
        if( !empty($labels) ) {

            foreach ( $labels as $label ) {

                $tagLabel = Tags::createLabel( $tag_id, $category, $label->locale, $label->label );

                if ($tagLabel !== false) {

                    $tagLabelResponse =  new TagLabelResponse($label->locale, $label->label);

                    $tagLabelsResponse->addResponse($tagLabelResponse);

                }

            }

        }

        return $tagLabelsResponse;

    }

}
