<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\Artist;
use RodinAPI\Models\City;
use RodinAPI\Models\SearchTerm;

class CitySearchTermFactory extends SearchTermFactory
{

    protected $tag_id;

    public function __construct($tag_id)
    {
        $this->tag_id = $tag_id;
    }

    public function create() {

        $city = City::factory('RodinAPI\Models\City')->findOne($this->tag_id, City::CATEGORY);

        if( !empty($city) ) {

            $locales = json_decode($city->locales);

            $labelEN = $locales->en->city_name.', '.$locales->en->country_name;
            $labelDK = $locales->dk->city_name.', '.$locales->dk->country_name;

            $termsCityEN    = self::getTerms($locales->en->city_name);
            $termsCityDK    = self::getTerms($locales->dk->city_name);

            foreach( $termsCityEN as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('en_'.$term, $labelEN, $this->tag_id);
            }

            foreach( $termsCityDK as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('dk_'.$term, $labelDK, $this->tag_id);
            }

        } else {
            throw new \Exception('Invalid city');
        }

    }

}