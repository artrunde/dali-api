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
     * Search
     */

    $v1->addGet(
        "/public/tags",
        [
            "controller" => "Search_Terms",
            "action"     => "query",
        ]
    );

    # ------------------------------------------------------------------------------
    # ADMIN ROUTES
    # ------------------------------------------------------------------------------

    /**
     * Debug
     */

    $v1->addGet(
        "/admin/debug",
        [
            "controller" => "Index",
            "action"     => "debug",
        ]
    );


    /**
     * Tags - Cities
     */

    $v1->addPost(
        "/admin/cities",
        [
            "controller" => "Cities",
            "action"     => "create",
        ]
    );

    $v1->addGet(
        "/admin/cities/{tag_id:}",
        [
            "controller" => "Cities",
            "action"     => "get",
        ]
    );

    $v1->addPut(
        "/admin/cities/{tag_id:}",
        [
            "controller" => "Cities",
            "action"     => "update",
        ]
    );

    $v1->addDelete(
        "/admin/cities/{tag_id:}",
        [
            "controller" => "Cities",
            "action"     => "delete",
        ]
    );

    /**
     * Artists
     */

    $v1->addPost(
        "/admin/artists",
        [
            "controller" => "Artists",
            "action"     => "create",
        ]
    );

    $v1->addGet(
        "/admin/artists/{tag_id:}",
        [
            "controller" => "Artists",
            "action"     => "get",
        ]
    );

    $v1->addDelete(
        "/admin/artists/{tag_id:}",
        [
            "controller" => "Artists",
            "action"     => "delete",
        ]
    );

    $v1->addPut(
        "/admin/artists/{tag_id:}",
        [
            "controller" => "Artists",
            "action"     => "update",
        ]
    );

    /**
     * Search Terms
     */
    $v1->addPost(
        "/admin/search-terms",
        [
            "controller" => "Search_Terms",
            "action"     => "create",
        ]
    );

    $v1->addDelete(
        "/admin/search-terms/{tag_id:}",
        [
            "controller" => "Search_Terms",
            "action"     => "delete"
        ]
    );


    // Add the group to the router
    $router->mount($v1);

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    return $router;

});