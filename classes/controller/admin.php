<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin controller handles template for admin interface
 *
 * @package    Eat.is
 * @category   Admin
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin extends Controller {
	
	private $menu = array(
		"places"     => "Places",
		"food"       => "Food",
		"categories" => "Categories",
		"users"      => "Users"
	);
	
	public function before()
	{
		$this->template = new View('smarty:admin/default');
		
		$this->template->menu = $this->menu;
		$this->template->controller = $this->request->controller;
		
		if (isset($_GET['profiler']))
		{
			$this->template->profiler = new View('profiler/stats');
		}
	}
	
	public function action_index()
	{
		
	}
	
	public function after()
	{
		$this->template->title = isset($this->title) ? $this->title : NULL;
		$this->request->response = $this->template;
	}
}
