<?php

namespace RodinAPI\Factories;

use RodinAPI\Models\CityLocale;

class CityLocaleFactory extends LocaleFactory
{

    /**
     * @param $locales
     * @return array
     * @throws \Exception
     */
    public function create($locales) {

        $locales = json_decode($locales);

        if( !empty($locales)) {

            foreach ( self::getLocales() as $locale ) {
                $this->localeArray[] = new CityLocale($locales->$locale->city_name, $locales->$locale->country_name);
            }

            return $this->localeArray;

        } else {
            throw new \Exception('Invalid city locales');
        }

    }

}