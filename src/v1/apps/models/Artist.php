<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class Artist extends ODM {

    const CATEGORY = 'category_artist';

	public $tag_id;

	public $belongs_to;

    public $locales;

    public $born_date;

    public $status;

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
        'create_time'   => 'S'
	);

    final public static function getCategory()
    {
        return str_replace('category_', '', self::CATEGORY);
    }

    /**
     * @param $locales
     * @param $born_date
     * @param $status
     * @return Artist $artist
     */
    public static function createArtistTag( $locales, $born_date, $status )
    {
        $artist = Artist::factory('RodinAPI\Models\Artist')->create();

        $artist_id            = uniqid('artist_');

        $artist->tag_id       = $artist_id;
        $artist->belongs_to   = self::CATEGORY;
        $artist->locales      = json_encode($locales);
        $artist->born_date    = (string) $born_date;
        $artist->status       = (string) $status;
        $artist->create_time  = date('c');

        $artist->save();

        return $artist;
    }
}