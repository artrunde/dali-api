<?php

namespace RodinAPI\Models;

use RodinAPI\Factories\SearchTermFactory;
use RodinAPI\Library\ODM;
use RodinAPI\Validators\ArtistValidator;

class Artist extends ODM {

    const CATEGORY = 'category_artist';

	public $tag_id;

	public $belongs_to;

    public $locales;

    public $born_date;

    public $status;

    public $searchable;

    public $create_time;

	protected $_table_name = 'rodin_tags_v1';

	protected $_hash_key = 'tag_id';

    protected $_range_key = 'belongs_to';

	protected $_schema = array(
        'tag_id'        => 'S',
        'belongs_to'    => 'S',
        'locales'       => 'M', // Map
        'born_date'     => 'S',
        'status'        => 'S',
        'searchable'    => 'BOOL',
        'create_time'   => 'S'
	);

    final public static function getCategory()
    {
        return str_replace('category_', '', self::CATEGORY);
    }

    /**
     * @param LocaleTypes $locales
     * @param $born_date
     * @param $status
     * @param $searchable
     * @return $this
     */
    public static function createArtistTag( LocaleTypes $locales, $born_date, $status, $searchable )
    {
        // Create artist
        $artist = Artist::factory('RodinAPI\Models\Artist')->create();

        $artist_id              = uniqid();

        $artist->tag_id         = $artist_id;
        $artist->belongs_to     = self::CATEGORY;
        $artist->locales        = json_encode($locales);
        $artist->born_date      = (string)$born_date;
        $artist->status         = (string)$status;
        $artist->create_time    = date('c');
        $artist->searchable     = $searchable;

        /**
         * Validate request
         */
        if( $artist->validate(new ArtistValidator())  === true ) {

            $artist->save();

            if (true === $artist->searchable) {

                $searchTerm = SearchTermFactory::factory($artist->tag_id, 'artist');
                $searchTerm->create();

            }

            return $artist;

        }

    }

    /**
     * @param $place_id
     * @param $artist_id
     * @return Artist|bool
     */
    public static function createTagRelation($place_id, $artist_id)
    {

        // Get city data
        $artist = Artist::factory('RodinAPI\Models\Artist')->findOne($artist_id, Artist::CATEGORY);

        if( !empty($artist) ) {

            $tagRelation = Tag::factory('RodinAPI\Models\Tag')->create();

            $tagRelation->tag_id = $artist_id;
            $tagRelation->belongs_to = 'place_' . $place_id;
            $tagRelation->category = Artist::getCategory();
            $tagRelation->create_time = date('c');

            $tagRelation->save();

            return $artist;

        }

        return false;

    }

}