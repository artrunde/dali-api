<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\Artist;
use RodinAPI\Models\SearchTerm;

class ArtistSearchTermFactory extends SearchTermFactory
{

    public function create() {

        $artist = Artist::factory('RodinAPI\Models\Artist')->findOne($this->tag_id, Artist::CATEGORY);

        if( !empty($artist) ) {

            // Create locales
            $artistLocales = LocaleFactory::create(Artist::getCategory(), json_decode($artist->locales));

            $labelEN = Artist::getCategory().'_'.$artistLocales->en->last_name.', '.$artistLocales->en->first_name;
            $labelDK = Artist::getCategory().'_'.$artistLocales->dk->last_name.', '.$artistLocales->dk->first_name;

            if( !empty($artistLocales->en->nickname) ) {
                $labelEN .= ' ('.$artistLocales->en->nickname.')';
            }

            if( !empty($artistLocales->dk->nickname) ) {
                $labelDK .= ' ('.$artistLocales->dk->nickname.')';
            }

            $termsLastEN    = self::getTerms($artistLocales->en->last_name);
            $termsFirstEN   = self::getTerms($artistLocales->en->first_name);
            $termsLastDK    = self::getTerms($artistLocales->dk->last_name);
            $termsFirstDK   = self::getTerms($artistLocales->dk->first_name);

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