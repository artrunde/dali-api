<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\Artist;
use RodinAPI\Models\SearchTerm;

class ArtistSearchTermFactory extends SearchTermFactory
{

    public function create() {

        $artist = Artist::factory('RodinAPI\Models\Artist')->findOne($this->tag_id, Artist::CATEGORY);

        if( !empty($artist) ) {

            $locales = json_decode($artist->locales);

            $labelEN = $locales->en->last_name.', '.$locales->en->first_name;
            $labelDK = $locales->dk->last_name.', '.$locales->dk->first_name;

            if( !empty($locales->en->nickname) ) {
                $labelEN .= ' ('.$locales->en->nickname.')';
            }

            if( !empty($locales->dk->nickname) ) {
                $labelDK .= ' ('.$locales->dk->nickname.')';
            }

            $termsLastEN    = self::getTerms($locales->en->last_name);
            $termsFirstEN   = self::getTerms($locales->en->first_name);
            $termsLastDK    = self::getTerms($locales->dk->last_name);
            $termsFirstDK   = self::getTerms($locales->dk->first_name);

            foreach( $termsLastEN as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('en_'.$term, $labelEN, $this->tag_id);
            }

            foreach( $termsFirstEN as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('en_'.$term, $labelEN, $this->tag_id);
            }

            foreach( $termsLastDK as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('dk_'.$term, $labelDK, $this->tag_id);
            }

            foreach( $termsFirstDK as $term ) {
                // Create search term
                SearchTerm::createSearchTerm('dk_'.$term, $labelDK, $this->tag_id);
            }

        } else {
            throw new \Exception('Invalid artist');
        }

    }

}