<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

/**
 * @var Di $di
 */
use Phalcon\Di;

$di->set('router', function () {

    $router = new Router(false);

    // Create a group with a common module and controller
    $v1 = new RouterGroup();
    $v1->setPrefix('/v1');


    /**
     * OPEN ROUTES
     */

    // Define a route
    $v1->addGet(
        "/public/search-terms/{search_terms:}",
        [
            "controller" => "Search_Terms",
            "action"     => "search",
        ]
    );

    $v1->addPost(
        "/public/queries/places/",
        [
            "controller" => "Queries",
            "action"     => "createPlace",
        ]
    );

    $v1->addGet(
        "/public/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "get",
        ]
    );

    $v1->addPost(
        "/public/places/",
        [
            "controller" => "Places",
            "action"     => "createPlace",
        ]
    );

    $v1->addGet(
        "/public/places/",
        [
            "controller" => "Places",
            "action"     => "getBulk",
        ]
    );

    $v1->addGet(
        "/public/debug/",
        [
            "controller" => "Index",
            "action"     => "debug",
        ]
    );

    // Add the group to the router
    $router->mount($v1);

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    return $router;

});