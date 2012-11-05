<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Base {

	public $title = "Home";

	/**
	 * Provide simple navigation through main features of the site.
	 *
	 * @return	Request
	 */
	public function action_index()
	{
		$this->template->view = View::factory('home/list');
	}

} // End Home
