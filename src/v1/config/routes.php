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
     * Tags
     */

    $v1->addGet(
        "/public/tags",
        [
            "controller" => "Search_Terms",
            "action"     => "query",
        ]
    );

    /**
     * Places
     */

    $v1->addGet(
        "/public/places",
        [
            "controller" => "Places",
            "action"     => "query",
        ]
    );

    $v1->addGet(
        "/public/places/{url_or_id:}",
        [
            "controller" => "Places",
            "action"     => "getPublic",
        ]
    );

    /**
     * Ping
     */

    $v1->add(
        "/public/ping",
        [
            "controller" => "Index",
            "action"     => "ping",
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
     * Tags
     */

    $v1->addPost(
        "/admin/places/{place_id:}/tags",
        [
            "controller" => "Tags",
            "action"     => "createRelation",
        ]
    );

    $v1->addDelete(
        "/admin/places/{place_id:}/tags/{tag_id:}",
        [
            "controller" => "Tags",
            "action"     => "deleteRelation",
        ]
    );

    $v1->addGet(
        "/admin/places/{place_id:}/tags",
        [
            "controller" => "Tags",
            "action"     => "getRelations",
        ]
    );

    /**
     * Places
     */

    $v1->addPost(
        "/admin/places",
        [
            "controller" => "Places",
            "action"     => "create",
        ]
    );

    $v1->addGet(
        "/admin/places",
        [
            "controller" => "Places",
            "action"     => "queryAdmin",
        ]
    );

    $v1->addGet(
        "/admin/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "get",
        ]
    );

    $v1->addDelete(
        "/admin/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "delete",
        ]
    );

    $v1->addPut(
        "/admin/places/{place_id:}",
        [
            "controller" => "Places",
            "action"     => "update",
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
        "/admin/cities",
        [
            "controller" => "Cities",
            "action"     => "query",
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
        "/admin/artists",
        [
            "controller" => "Artists",
            "action"     => "query",
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

    // Add the group to the router
    $router->mount($v1);

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    return $router;

});