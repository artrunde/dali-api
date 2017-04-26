<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\ArtistLocale;
use RodinAPI\Models\CityLocale;
use RodinAPI\Models\LocaleTypes;
use RodinAPI\Models\PlaceLocale;
use RodinAPI\Validators\ArtistLocaleValidator;
use RodinAPI\Validators\CityLocaleValidator;
use RodinAPI\Validators\PlaceLocaleValidator;

class LocaleFactory
{

    const LOCALES = array('dk','en');

    public static function create($type, $data)
    {

        if ( !is_object($data) ) {
            // Check if parsed JSON
            $data = json_decode($data);
        }

        $localeTypes = new LocaleTypes();

        foreach( self::LOCALES as $locale ) {

            switch($type) {

                case 'city':

                    $city = new CityLocale($data->$locale->city_name, $data->$locale->country_name);
                    $city->validate(new CityLocaleValidator());

                    $localeTypes->addLocale($locale, $city);

                    break;

                case 'artist':

                    $artist = new ArtistLocale($data->$locale->first_name, $data->$locale->last_name, $data->$locale->nickname);
                    $artist->validate(new ArtistLocaleValidator());

                    $localeTypes->addLocale($locale, $artist);

                    break;

                case 'place':

                    $place = new PlaceLocale($data->$locale->place_name, $data->$locale->address1_name, $data->$locale->address2_name, $data->$locale->postal_code, $data->$locale->city_name, $data->$locale->country_name);
                    $place->validate(new PlaceLocaleValidator());

                    $localeTypes->addLocale($locale, $place);

                    break;

                default:
                    throw new \Exception('Unknown category for locale');

            }

        }

        return $localeTypes;
    }

}