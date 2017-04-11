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

    $v1->addPost(
        "/admin/tags",
        [
            "controller" => "Tags",
            "action"     => "createTag",
        ]
    );

    $v1->addGet(
        "/admin/tags/{tag_id:}",
        [
            "controller" => "Tags",
            "action"     => "getTag",
        ]
    );

    $v1->addDelete(
        "/admin/tags/{tag_id:}",
        [
            "controller" => "Tags",
            "action"     => "deleteTag",
        ]
    );

    /*

    $v1->addGet(
        "/admin/tags/{tag_id:}/labels/{locale:}",
        [
            "controller" => "Tags",
            "action"     => "getLabel",
        ]
    );

    $v1->addPut(
        "/admin/tags/{tag_id:}/labels/{locale:}",
        [
            "controller" => "Tags",
            "action"     => "updateLabel",
        ]
    );

    $v1->addDelete(
        "/admin/tags/{tag_id:}/labels/{locale:}",
        [
            "controller" => "Tags",
            "action"     => "deleteLabel",
        ]
    );

    $v1->addPost(
        "/admin/tags/{tag_id:}/labels/{locale:}",
        [
            "controller" => "Tags",
            "action"     => "createLabel",
        ]
    );

*/
    # ------------------------------------------------------------------------------
    # PUBLIC ROUTES
    # ------------------------------------------------------------------------------

    /**
     * TAGS
     */

    $v1->addGet(
        "/public/tags",
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

    // Add the group to the router
    $router->mount($v1);

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    return $router;

});