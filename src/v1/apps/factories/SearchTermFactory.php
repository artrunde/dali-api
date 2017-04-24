<?php

namespace RodinAPI\Factories;

abstract class SearchTermFactory
{

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    abstract public function create();

    /**
     * @param $id
     * @param $type
     * @return bool|SearchTermFactory
     */
    public static function factory( $id, $type )
    {

        switch ( $type ) {

            case "artist":
                return new ArtistSearchTermFactory($id);
                break;
            case "city":
                return new CitySearchTermFactory($id);
                break;
            case "place":
                return new PlaceSearchTermFactory($id);
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

        $length = mb_strlen($string);

        for( $i=3; $i<=$length; $i++) {

            $returnArray[] = mb_substr($string, 0, $i );

        }

        return $returnArray;

    }

}