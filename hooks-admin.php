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

Hooks::after("Place > /v1/admin/places > Create place > 200 > application/json", function(&$transaction) {

    global $STASH;

    $parsedBody = json_decode($transaction->real->body);

    $STASH['place']['place_id'] = $parsedBody->place_id;
    $STASH['place']['locales']  = $parsedBody->locales;

});

Hooks::before("Artist > /v1/admin/artists/{artist_id} > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("artist_id", $transaction->fullPath, $STASH['artist']['artist_id']);

    echo $transaction->fullPath ;

});

Hooks::before("Place > /v1/admin/places/{place_id} > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("place_id", $transaction->fullPath, $STASH['place']['place_id']);

    echo $transaction->fullPath;

});

Hooks::before("Place > /v1/admin/places/{place_id}/tags/{tag_id} > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("place_id", $transaction->fullPath, $STASH['place']['place_id']);

    echo $transaction->fullPath;

});

Hooks::before("Place > /v1/admin/places/{place_id}/tags > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("place_id", $transaction->fullPath, $STASH['place']['place_id']);

    echo $transaction->fullPath;

});


Hooks::before("City > /v1/admin/cities/{city_id} > *", function(&$transaction) {

    global $STASH;

    $transaction->fullPath = replaceURI("city_id", $transaction->fullPath, $STASH['city']['city_id']);

    echo $transaction->fullPath ;

});

/**********************************
 *              PUBLIC
 **********************************/

/*
 *
 *
 $marshaler = new Marshaler();
$client = new DynamoDbClient([
    'version'  => 'latest',
    'region'   => 'eu-west-1'
]);

$item = $marshaler->marshalJson('
    {
        "tag_id": "58f9d0337adb4",
        "belongs_to": "category_artist"
    }
');

$params = [
    'TableName' => 'rodin_tags_v1_dev',
    'Item' => $item
];

try {
    $result = $client->putItem($params);

} catch (DynamoDbException $e) {
    echo "Unable to add item:\n";
    echo $e->getMessage() . "\n";
}
 */