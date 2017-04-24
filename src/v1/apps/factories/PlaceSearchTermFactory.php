<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\Place;
use RodinAPI\Models\SearchTerm;

class PlaceSearchTermFactory extends SearchTermFactory
{

    public function create() {

        $place = Place::factory('RodinAPI\Models\Place')->findOne($this->id);

        if( !empty($place) ) {

            // Create locales
            $placeLocales = LocaleFactory::create('place', json_decode($place->locales));

            $labelEN = 'place_'.$placeLocales->en->place_name.', '.$placeLocales->en->city_name;
            $labelDK = 'place_'.$placeLocales->dk->place_name.', '.$placeLocales->dk->city_name;

            $termsCityEN    = self::getTerms($placeLocales->en->place_name);
            $termsCityDK    = self::getTerms($placeLocales->dk->place_name);

            foreach( $termsCityEN as $term ) {

                // Create search term
                SearchTerm::createSearchTerm('en_'.$term, $labelEN, $this->id);

            }

            foreach( $termsCityDK as $term ) {

                // Create search term
                SearchTerm::createSearchTerm('dk_'.$term, $labelDK, $this->id);

            }

        } else {
            throw new \Exception('Invalid place for search terms');
        }

    }

}