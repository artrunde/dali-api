<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\City;
use RodinAPI\Models\SearchTerm;

class CitySearchTermFactory extends SearchTermFactory
{

    public function create() {

        $city = City::factory('RodinAPI\Models\City')->findOne($this->tag_id, City::CATEGORY);

        if( !empty($city) ) {

            // Create locales
            $cityLocales = LocaleFactory::create('city', json_decode($city->locales));

            $labelEN = $cityLocales->en->city_name.', '.$cityLocales->en->country_name;
            $labelDK = $cityLocales->dk->city_name.', '.$cityLocales->dk->country_name;

            $termsCityEN    = self::getTerms($cityLocales->en->city_name);
            $termsCityDK    = self::getTerms($cityLocales->dk->city_name);

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