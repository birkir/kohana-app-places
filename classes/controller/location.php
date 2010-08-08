<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Location controller is there to give the user ability to save his current
 * location by picking it from a map or just use internal GPS receiver from
 * his/her device. Geolocation is stored with browser cookies.
 * 
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */class Controller_Location extends Controller_Interface {
	
	public $title = 'Location';

	/**
	 * Show current location if available.
	 *
	 * @return	object	View
	 */	
	public function action_index()
	{
		$this->template->view = new View('smarty:location/default');
		
		if (isset($_REQUEST['location']))
		{
			$res = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".urlencode($_REQUEST['location'])."&sensor=false");
			$res = json_decode($res);
			
			// Check if geocoding was successful
			if ($res->status == "OK")
			{
				$geo = $res->results[0]->geometry->location;
				Cookie::set("address", $res->results[0]->formatted_address);
				Cookie::set("lat", $geo->lat);
				Cookie::set("lng", $geo->lng);
				
				$this->request->redirect("/location");
			}
			else
			{
				$this->template->view->status = FALSE;
			}
		}
		
		// Attach Address
		$this->template->view->address = Cookie::get("address", NULL);
		
		// Display map
		if (Cookie::get("lat", NULL))
		{
			$this->template->view->map = "http://maps.google.com/maps/api/staticmap?center=".Cookie::get("address")."&zoom=14&size=388x300&maptype=roadmap&sensor=false&markers=color:blue|label:S|".Cookie::get("lat", NULL).",".Cookie::get("lng", NULL);
		}
	}
	
	/**
	 * Set current location with _GET request, is used by GPS.
	 *
	 * @return 	array		Status code
	 */
	public function action_set()
	{
		if (isset($_GET['lat']) AND isset($_GET['lat']))
		{
			$res = file_get_contents("http://maps.google.com/maps/api/geocode/json?latlng=".urlencode($_GET['lat'].",".$_GET['lng'])."&sensor=false");
			$res = json_decode($res);

			// Check if geocoding was successful
			if ($res->status == "OK")
			{
				$geo = $res->results[0]->geometry->location;
				Cookie::set("address", $res->results[0]->formatted_address);
				Cookie::set("lat", $geo->lat);
				Cookie::set("lng", $geo->lng);
				die(json_encode(array("status" => "OK")));
			}
		}
		
		die(json_encode(array("status" => "BAD")));
	}
	}
