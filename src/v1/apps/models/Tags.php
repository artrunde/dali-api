<?php

namespace RodinAPI\Models;


use RodinAPI\Library\ODM;

class Tags extends ODM {

	public $tag_id;

	public $belongs_to;

	public $label;

    public $create_time;

	protected $_table_name = 'rodin_tags_v1';

	protected $_hash_key = 'tag_id';

    protected $_range_key = 'belongs_to';

	protected $_schema = array(
		'tag_id'        => 'S',
		'belongs_to'    => 'S',
        'label'         => 'S',
        'create_time'   => 'S'
	);

    public static function getCategory($belongs_to)
    {
        return str_replace('category_', '', $belongs_to);
    }

    /**
     * @param array $tags
     * @return mixed
     */
    public static function getCategoryFromMultipleTags(array $tags)
    {

        /**
         * @var Tags $tag
         */
        foreach ($tags as $tag) {

            if( strpos($tag->belongs_to, 'category_') !== false ) {
                return self::getCategory($tag->belongs_to);
            }

        }

    }

    /**
     * @param $label
     * @param $locale
     * @param $category_class
     * @param $category_attribute
     * @return $this|bool
     */
	public static function createTag($label, $locale, $category_class, $category_attribute )
    {

        $belongs_to = $locale;
        $tag_prefix = $category_class.'-'.$category_attribute.'_';

        // Check if already exists
        $tags = Tags::factory('RodinAPI\Models\Tags')
            ->where('label', '=', $label)
            ->where('belongs_to', '=', $belongs_to)
            ->index('LabelBelongsToIndex')
            ->findFirst(array('Select' => 'ALL_PROJECTED_ATTRIBUTES'));

        if( empty($tags) ) {

            $tag = Tags::factory('RodinAPI\Models\Tags')->create();

            $tag->tag_id        = uniqid($tag_prefix);
            $tag->belongs_to    = $belongs_to;
            $tag->create_time   = date('c');
            $tag->label         = trim($label);

            $tag->save();

            return $tag;

        } else {
            return false;
        }
    }

    /**
     * @param $category
     * @return $this
     */
    public static function createTagNoLabels( $category )
    {
        $tag = Tags::factory('RodinAPI\Models\Tags')->create();

        $tag_id             = uniqid();

        $tag->tag_id        = $tag_id;
        $tag->belongs_to    = 'category_'.$category;      // Belongs to self. Later will labels and locales can be added
        $tag->create_time   = date('c');

        $tag->save();

        return $tag;
    }

    /**
     * @param $tag_id
     * @param $category
     * @param $locale
     * @param $label
     * @return $this|bool
     */
    public static function createLabel( $tag_id, $category, $locale, $label )
    {

        $tag = Tags::factory('RodinAPI\Models\Tags')->findOne($tag_id, 'category_'.$category);

        if( !empty($tag) ) {

            $tagNew = Tags::factory('RodinAPI\Models\Tags')->create();

            $tagNew->tag_id         = $tag_id;
            $tagNew->belongs_to    = 'locale_'.$locale;
            $tagNew->label         = $label;
            $tagNew->create_time   = date('c');

            try {

                $tagNew->save();

                return $tagNew;

            } catch (\Exception $e) {
                return false;
            }

        } else {
            return false;
        }
    }

}