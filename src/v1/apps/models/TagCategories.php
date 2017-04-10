<?php

namespace RodinAPI\Models;

/**
 * Class TagCategories
 * @package RodinAPI\Models
 */
class TagCategories extends VirtualModel {

	public $class;

	public $attribute;

    /**
     * @param $tag_id
     * @return TagCategories
     */
    public static function getCategoryFromTagId($tag_id) {

        $categoryExploded = explode('_', $tag_id);
        $categoryExploded = explode('-', $categoryExploded[0]);

        $category = new TagCategories();

        $category->class        = $categoryExploded[0];
        $category->attribute    = $categoryExploded[1];

        return $category;

    }

}