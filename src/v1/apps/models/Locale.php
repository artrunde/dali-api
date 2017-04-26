<?php

namespace RodinAPI\Models;

use RodinAPI\Validators\BaseValidator;

abstract class Locale {

    final public function validate( BaseValidator $validator )
    {
        $validator->validate($this);
    }

}