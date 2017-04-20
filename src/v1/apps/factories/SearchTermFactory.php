<?php

namespace RodinAPI\Factories;

abstract class SearchTermFactory
{

    protected $tag_id;

    public function __construct($tag_id)
    {
        $this->tag_id = $tag_id;
    }

    public static function getTagType($tag_id)
    {
        $type = explode('_', $tag_id);
        return $type[0];
    }

    abstract public function create();

    /**
     * @param $tag_id
     * @return bool|SearchTermFactory
     */
    public static function factory( $tag_id )
    {

        switch ( self::getTagType($tag_id) ) {

            case "artist":
                return new ArtistSearchTermFactory($tag_id);
                break;
            case "city":
                return new CitySearchTermFactory($tag_id);
                break;
            default:
                return false;

        }

    }

    /**
     * @param $string
     * @return array
     */
    final public static function getTerms( $string ) {

        $returnArray = array();

        $length = strlen($string);

        for( $i=3; $i<=$length; $i++) {

            $returnArray[] = substr($string, 0, $i );

        }

        return $returnArray;

    }

}