<?php

namespace DaliAPI\Controllers;

use DaliAPI\Models\Places;
use DaliAPI\Response\PlaceResponse;
use Phalcon\Mvc\Controller;

class PlacesController extends Controller
{

    public function getAction($place_id)
    {

        $place = Places::factory('DaliAPI\Models\Places')->findOne($place_id);

        if(empty($place)) {
            echo "Empty"; // TODO
            die;
        } else {
            return new PlaceResponse($place->place_id, $place->url_id);
        }

    }
}
