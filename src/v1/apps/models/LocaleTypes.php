<?php

namespace RodinAPI\Models;

class LocaleTypes {

    public $dk;

    public $en;

    public function addLocale($country, Locale $localeObj) {

        $this->$country = $localeObj;

        return $this;

    }
}
