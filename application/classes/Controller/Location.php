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
 */
class Controller_Location extends Controller_Base {

	public $title = 'Location';

	/**
	 * Show current location if available and the option to get location from
	 * GPS device or enter it manually.
	 *
	 * @return	View
	 */	
	public function action_index()
	{
		// display location setter
		$this->template->view = View::factory('location/set')
		->bind('post', $post)
		->bind('address', $address)
		->bind('coords', $coords);

		// read filtered $_POST data
		$post = $this->request->post();

		// set address
		$address = Cookie::get('address', NULL);

		// set coords
		$coords = array(
			'latitude' => Cookie::get('lat', 0.00000),
			'longitude' => Cookie::get('lng', 0.00000)
		);

		// check if user posted
		if (HTTP_Request::POST == $this->request->method())
		{
			// build params
			$param = Arr::get($post, 'gps') ? 'latlng='.urlencode(Arr::get($post, 'lat').','.Arr::get($post, 'lng')) : 'address='.urlencode(Arr::get($post, 'location'));

			// do google maps geocoding api request
			$maps = json_decode(file_get_contents('http://maps.google.com/maps/api/geocode/json?'.$param.'&sensor='.(Arr::get($post, 'lat') ? 'true' : 'false')));

			// check for good answer
			if ($maps->status === 'OK')
			{
				// set some cookies
				Cookie::set('address', $maps->results[0]->formatted_address);
				Cookie::set('lat', $maps->results[0]->geometry->location->lat);
				Cookie::set('lng', $maps->results[0]->geometry->location->lng);

				// fix assigned address
				$address = $maps->results[0]->formatted_address;
				$coords['latitude'] = $maps->results[0]->geometry->location->lat;
				$coords['longitude'] = $maps->results[0]->geometry->location->lng;
			}
			else
			{
				$this->template->view->failed = TRUE;
			}
		}
	}
} // End Location