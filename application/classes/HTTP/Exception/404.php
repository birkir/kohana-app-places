<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {

	public function get_response()
	{
		$response = Response::factory();

		$view = View::factory('template');

		$view->view = '<section><h1>'.__('404 Error').'</h1><p>'.$this->getMessage().'</p></section>';

		$response->body($view->render());

		return $response;
	}

}
