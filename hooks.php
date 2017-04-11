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

Hooks::after("Tag > /v1/admin/tags > Create a tag > 200 > application/json", function(&$transaction) {

    global $STASH;

    $parsedBody = json_decode($transaction->real->body);

    $STASH['tag_id'] = $parsedBody->tag_id;

});

Hooks::before("Tag > /v1/admin/tags/{tag_id} > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("tagid", $transaction->fullPath, $STASH['tag_id']);

});