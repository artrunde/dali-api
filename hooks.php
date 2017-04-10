<?php

require_once 'vendor/autoload.php';

use Dredd\Hooks;

Hooks::before("Tag > /v1/admin/tags > Create tag > 200 > application/json", function(&$transaction) {

    $array = array(
        "category" => array (
            "class"     => "country",
            "attribute" => "name"
        ),
        "labels" => array (
            array(
                "locale" => "en",
			    "label" => uniqid("dredd_country_")
            ),
            array(
                "locale" => "dk",
                "label" => uniqid("dredd_land_")
            )
        )
    );

    $transaction->request->body = json_encode($array);

});

Hooks::before("Tag > /v1/admin/tags/{tag_id} > Get tag > *", function(&$transaction) {


    var_dump($transaction);
    die;

});