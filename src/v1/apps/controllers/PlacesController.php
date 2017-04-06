<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\BadRequestException;
use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\Places;
use RodinAPI\Response\PlaceResponse;
use RodinAPI\Response\PlacesResponse;

class PlacesController extends BaseController
{

	public function getAction($place_id)
	{
	    // Check query param
        if( !empty($place_id) ) {

            // TODO get the from ODM
            $place = Places::factory('RodinAPI\Models\Places');

            $place->place_id    = '77eec5400965';
            $place->url_path    = 'kalles-house-of-arts';
            $place->name        = "Kalles house of Arts";
            $place->address     = array("address_1" => "Vesterbro 122", "address_2" => "", "postal_code" => "5000", "country" => "Denmark", "country_abbrev" => "dk");
            $place->vat_number  = '01234567';
            $place->create_time = "2010-12-21T17:42:34+00:00";

            return new PlaceResponse($place->place_id, $place->url_path, $place->name, $place->address, $place->vat_number, $place->create_time);

        } else {
            throw new ItemNotFoundException('Place not found');
        }

	}

    public function searchAction()
    {
        $tags = $this->request->getQuery('tags');

        // Check query param
        if( !empty($tags) ) {

            // TODO get the from ODM
            $place1 = Places::factory('RodinAPI\Models\Places');
            $place2 = Places::factory('RodinAPI\Models\Places');
            $place3 = Places::factory('RodinAPI\Models\Places');

            $responseArray = new PlacesResponse();

            $place1->place_id    = '77eec5400965';
            $place1->url_path    = 'kalles-house-of-arts';
            $place1->name        = "Kalles house of Arts";
            $place1->address     = array("address_1" => "Vesterbro 122", "address_2" => "", "postal_code" => "5000", "country" => "Denmark", "country_abbrev" => "dk");
            $place1->vat_number  = '01234567';
            $place1->create_time = "2010-12-21T17:42:34+00:00";

            $place2->place_id    = '77eec5400965';
            $place2->url_path    = 'kalles-house-of-arts';
            $place2->name        = "Kalles house of Arts";
            $place2->address     = array("address_1" => "Vesterbro 122", "address_2" => "", "postal_code" => "5000", "country" => "Denmark", "country_abbrev" => "dk");
            $place2->vat_number  = '01234567';
            $place2->create_time = "2010-12-21T17:42:34+00:00";

            $place3->place_id    = '77eec5400965';
            $place3->url_path    = 'kalles-house-of-arts';
            $place3->name        = "Kalles house of Arts";
            $place3->address     = array("address_1" => "Vesterbro 122", "address_2" => "", "postal_code" => "5000", "country" => "Denmark", "country_abbrev" => "dk");
            $place3->vat_number  = '01234567';
            $place3->create_time = "2010-12-21T17:42:34+00:00";

            $response1 = new PlaceResponse($place1->place_id, $place1->url_path, $place1->name, $place1->address, $place1->vat_number, $place1->create_time);
            $response2 = new PlaceResponse($place2->place_id, $place2->url_path, $place2->name, $place2->address, $place2->vat_number, $place2->create_time);
            $response3 = new PlaceResponse($place3->place_id, $place3->url_path, $place3->name, $place3->address, $place3->vat_number, $place3->create_time);

            $responseArray->addResponse($response1);
            $responseArray->addResponse($response2);
            $responseArray->addResponse($response3);

            return $responseArray;

        } else {
            throw new BadRequestException('Invalid tags in query');
        }

    }

}
