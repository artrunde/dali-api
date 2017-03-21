<?php

use Phalcon\Mvc\Router;

/**
 * @var Di $di
 */
use Phalcon\Di;

$di->set('router', function () {

    $router = new Router(false);

    // Define a route
    $router->addGet(
        "/search-terms/{search_terms:}",
        [
            "controller" => "Search_Terms",
            "action"     => "search",
        ]
    );

    $router->addPost(
        "/queries/places/",
        [
            "controller" => "Queries",
            "action"     => "createPlace",
        ]
    );

    $router->addGet(
        "/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "get",
        ]
    );

    $router->addGet(
        "/debug/",
        [
            "controller" => "Index",
            "action"     => "debug",
        ]
    );

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    return $router;

});