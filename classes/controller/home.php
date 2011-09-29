<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Interface {
	
	public $title = "Home";
	
	/**
	 * Provide simple navigation through main features of the site.
	 *
	 * @return	Request
	 */
	public function action_index()
	{
		$view = new View('misc/menu');
		
		$view->menu = (object) array(
			(object) array(
				"title" => "Places",
				"alias" => "places"
			),
			(object) array(
				"title" => "Random",
				"alias" => "places/random"
			),
			(object) array(
				"title" => "Food types",
				"alias" => "places/food_types"
			),
			(object) array(
				"title" => "Price range",
				"alias" => "places/price_range"
			),
			(object) array(
				"title" => "What's close?",
				"alias" => "places/neighborhood"
			)
		);
		
		$this->template->view = $view;
	}

} // End Controller_Home
