<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Neighborhood controller finds all places near you
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Neighborhood extends Controller_Interface {
	
	public function action_index()
	{
		$place = new Model_Place();
		
		$this->template->view = new View('smarty:neighborhood/default');
		
		$distance = $place->select($place->near(Cookie::get("lat", 0), Cookie::get("lng", 0)));
		
		$this->template->view->places = $distance->order_by("distance", "ASC")->find_all();
		
	}
	
}