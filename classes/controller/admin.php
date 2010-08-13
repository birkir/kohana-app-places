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
		$user = ORM::factory('user');
		
		$this->template = new View('smarty:admin/default');
		
		$this->template->menu = $this->menu;
		
		$this->template->controller = $this->request->controller;
		
		if ($this->request->controller != 'login' AND !$user->logged_in())
		{
			$this->request->redirect('admin/login');
		}
		
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
