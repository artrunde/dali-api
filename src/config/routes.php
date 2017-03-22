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
        "/dali-public/search-terms/{search_terms:}",
        [
            "controller" => "Search_Terms",
            "action"     => "search",
        ]
    );

    $router->addPost(
        "/dali-public/queries/places/",
        [
            "controller" => "Queries",
            "action"     => "createPlace",
        ]
    );

    $router->addGet(
        "/dali-public/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "get",
        ]
    );

    $router->addGet(
        "/dali-public/places/",
        [
            "controller" => "Places",
            "action"     => "getBulk",
        ]
    );

    $router->addGet(
        "/dali-public/debug/",
        [
            "controller" => "Index",
            "action"     => "debug",
        ]
    );

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    return $router;

});