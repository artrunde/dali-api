<?php

require_once 'vendor/autoload.php';

global $STASH;

use Dredd\Hooks;

function replaceURI($needle, $haystack, $replace) {

    $pos = strpos($haystack, $needle);

    if ($pos !== false) {
        $haystack = substr_replace($haystack, $replace, $pos, strlen($needle));
    }

    return $haystack;

}

Hooks::beforeEach(function(&$transaction) {
   echo $transaction->name;
});

Hooks::after("Artist > /v1/admin/artists > Create artist > 200 > application/json", function(&$transaction) {

    global $STASH;

    $parsedBody = json_decode($transaction->real->body);

    $STASH['artist']['artist_id'] = $parsedBody->artist_id;
    $STASH['artist']['locales'] = $parsedBody->locales;

});

Hooks::after("City > /v1/admin/cities > Create city > 200 > application/json", function(&$transaction) {

    global $STASH;

    $parsedBody = json_decode($transaction->real->body);

    $STASH['city']['city_id'] = $parsedBody->city_id;
    $STASH['city']['locales'] = $parsedBody->locales;

});

Hooks::before("Artist > /v1/admin/artists/{artist_id} > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("artist_id", $transaction->fullPath, $STASH['artist']['artist_id']);

    echo $transaction->fullPath ;

});

Hooks::before("City > /v1/admin/cities/{city_id} > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("city_id", $transaction->fullPath, $STASH['city']['city_id']);

    echo $transaction->fullPath ;

});