<?php

use Phalcon\Mvc\Router;

/**
 * @var Di $di
 */
use Phalcon\Di;

$di->set('router', function () {

    $router = new Router(false);

    /**
     * OPEN ROUTES
     */

    // Define a route
    $router->addGet(
        "/rodin-public/search-terms/{search_terms:}",
        [
            "controller" => "Search_Terms",
            "action"     => "search",
        ]
    );

    $router->addPost(
        "/rodin-public/queries/places/",
        [
            "controller" => "Queries",
            "action"     => "createPlace",
        ]
    );

    $router->addGet(
        "/rodin-public/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "get",
        ]
    );

    $router->addGet(
        "/rodin-public/places/",
        [
            "controller" => "Places",
            "action"     => "getBulk",
        ]
    );

    $router->addGet(
        "/rodin-public/debug/",
        [
            "controller" => "Index",
            "action"     => "debug",
        ]
    );

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    return $router;

});