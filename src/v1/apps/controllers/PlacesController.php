<?php

namespace RodinAPI\Controllers;

use RodinAPI\Exceptions\ItemNotFoundException;
use RodinAPI\Models\Places;
use RodinAPI\Response\PlaceResponse;

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

}
