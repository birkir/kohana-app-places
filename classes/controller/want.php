<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Want extends Controller_Interface {

	/**
	 * List all food types
	**/
	public function action_index()
	{
		$view = new View('smarty:home/default');
		
		$view->menu = ORM::factory('food')
		->order_by('title', 'ASC')
		->find_all();
		
		$view->prefix = 'places/food/';
		
		$this->template->view = $view;
	}

}
