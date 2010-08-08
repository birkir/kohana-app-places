<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Interface {

	public $title = "Home";

	public function action_index()
	{
		$view = new View('smarty:home/default');
		
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
				"title" => "I want ...",
				"alias" => "food"
			),
			(object) array(
				"title" => "What's close?",
				"alias" => "neighborhood"
			)
		);
		
		$this->template->view = $view;
	}

} // End Controller_Home
