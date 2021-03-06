<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\City;
use RodinAPI\Models\SearchTerm;

class CitySearchTermFactory extends SearchTermFactory
{

    public function create() {

        $city = City::factory('RodinAPI\Models\City')->findOne($this->id, City::CATEGORY);

        if( !empty($city) ) {

            // Create locales
            $cityLocales = LocaleFactory::create(City::getCategory(), json_decode($city->locales));

            $labelEN = City::getCategory().'_'.$cityLocales->en->city_name.', '.$cityLocales->en->country_name;
            $labelDK = City::getCategory().'_'.$cityLocales->dk->city_name.', '.$cityLocales->dk->country_name;

            $termsCityEN    = self::getTerms($cityLocales->en->city_name);
            $termsCityDK    = self::getTerms($cityLocales->dk->city_name);

            foreach( $termsCityEN as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('en_'.$term, $labelEN, $this->id);
            }

            foreach( $termsCityDK as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('dk_'.$term, $labelDK, $this->id);
            }

        } else {
            throw new \Exception('Invalid city');
        }

    }

}