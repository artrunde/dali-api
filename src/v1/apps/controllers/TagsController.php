<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\TagCategories;
use RodinAPI\Models\TagLabels;
use RodinAPI\Models\Tags;
use RodinAPI\Response\TagCategoryResponse;
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
    public function getAction($tag_id)
    {

        $tags = Tags::factory('RodinAPI\Models\Tags')
            ->where('tag_id','=', $tag_id)
            ->findMany();

        if( !empty($tags) ) {

            $labelsResponse = new TagLabelsResponse();

            if( !empty($tags) ) {

                foreach ($tags as $tag) {

                    $category           = TagCategories::getCategoryFromTagId($tag_id);
                    $categoryResponse   = new TagCategoryResponse($category->class, $category->attribute);

                    if( TagLabels::validLocale($tag->belongs_to) ) {
                        $labelResponse      = new TagLabelResponse($tag->belongs_to, $tag->label);
                        $labelsResponse->addResponse($labelResponse);
                    }

                }

                return new TagResponse( $tag_id, $categoryResponse, $labelsResponse  );

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

    public function updateLabelAction($tag_id, $locale)
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        $tag = Tags::factory('RodinAPI\Models\Tags')->findOne($tag_id, $locale);

        if( !empty($tag) ) {

            $tag->label = $body->label;
            $tag->save();

            return new TagLabelResponse($locale, $tag->label);

        }

        throw new ItemNotFoundException('Could not find specified label');

    }

    public function deleteLabelAction($tag_id, $locale)
    {

        $tag = Tags::factory('RodinAPI\Models\Tags')->findOne($tag_id, $locale);

        if( !empty($tag) ) {
            $tag->delete();
            $this->response->setStatusCode(200);
            $this->response->send();
            $this->response->setJsonContent(null);
            die;
        }

        throw new ItemNotFoundException('Could not find specified label');

    }



    /**
     * @return TagResponse
     * @throws BadRequestException
     */
    public function createAction()
    {
        // Get body
        $body = $this->request->getJsonRawBody();

        $tag = Tags::createTagNoLabels( $body->category->class, $body->category->attribute );

        if( $tag !== false ) {

            // Create labels
            if( !empty($body->labels) ) {
                $tagLabelsResponse = $this->createLabel($tag->tag_id, $body->labels);
            }

            $category = new TagCategoryResponse( $body->category->class, $body->category->attribute );

            return new TagResponse( $tag->tag_id, $category, $tagLabelsResponse );

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

                    $tagLabelResponse =  new TagLabelResponse($label->locale, $label->label);

                    $tagLabelsResponse->addResponse($tagLabelResponse);

                } else {
                    throw new BadRequestException('Tag does already exist for this locale');
                }

            }

        }

        return $tagLabelsResponse;

    }

}
