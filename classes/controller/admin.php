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
	
	public $json = FALSE;
	public $user;
	public $items_per_page = 5;
	
	public function before()
	{
		$this->user = ORM::factory('user');
		
		$this->template = new View('smarty:admin/default');
		
		$this->template->menu = $this->menu;
		
		View::set_global('controller', $this->request->controller);
		
		$this->_user = $this->user->logged_in();
		
		if ($this->request->controller != 'login' AND !$this->_user)
		{
			$this->request->redirect('admin/login');
		}
		
		View::set_global('user', ORM::factory('user', $this->_user));
		
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
		if ($this->json == FALSE)
		{
			$this->template->title = isset($this->title) ? $this->title : NULL;
			$this->request->response = $this->template;
		}
	}
}
