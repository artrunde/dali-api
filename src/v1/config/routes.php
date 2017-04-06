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

    # ------------------------------------------------------------------------------
    # PUBLIC ROUTES
    # ------------------------------------------------------------------------------

    /**
     * TAGS
     */

    $v1->addGet(
        "/public/tags/",
        [
            "controller" => "Search_Terms",
            "action"     => "search",
        ]
    );

    /**
     * Places
     */

    $v1->addGet(
        "/public/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "get",
        ]
    );

    /**
     * Debug
     */

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