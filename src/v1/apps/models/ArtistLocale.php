<?php

namespace RodinAPI\Models;

class ArtistLocale extends Locale  {

    public $first_name;

    public $last_name;

    public $nickname;

    public function __construct($first_name, $last_name, $nickname)
    {
        $this->first_name      = $first_name;
        $this->last_name       = $last_name;
        $this->nickname        = $nickname;
    }

}