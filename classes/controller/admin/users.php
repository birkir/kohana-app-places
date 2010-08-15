<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller that handles manipulation of user accounts.
 * Create, edit and delete users.
 *
 * @package    Eat.is
 * @category   Admin
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin_Users extends Controller_Admin {

	public $title = "Users";
	public $food, $view;
	
	public function before()
	{
		parent::before();
		$this->user = ORM::factory('user');
	}
	
	public function action_index()
	{
		$this->view = new View('smarty:admin/list');
		
		$this->view->fields = array(
			'username' => 'Username',
			'email' => 'Email',
			'last_login' => 'Last login',
			'logins' => 'Total logins'
		);
		
		$count = $this->user->where('removed', '=', 0)->find_all()->count();
		
		$this->view->pagination = Pagination::factory(array(
			'view'           => 'admin/pagination',
			'total_items'    => $count,
			'items_per_page' => $this->items_per_page,
		));
		
		$this->view->control = Inflector::singular($this->request->controller);
		
		$this->view->items = $this->user
		->order_by('user_id', 'ASC')
		->limit($this->view->pagination->items_per_page)
		->offset($this->view->pagination->offset)
		->find_all();
	}
	
	public function action_new()
	{
		$_POST = array(
			'username' => 'odinn',
			'email' => 'odinn@eat.is',
			'title' => 'Óðinn Þráinsson',
			'password' => 'maniac',
			'password_confirm' => 'maniac'
		);
		
		if ($_POST)
		{
			$post = $this->user->validate_create($_POST);
			
			if ($post->check())
			{
				$this->user
				->values($post)
				->save();
				
				$role = new Model_Role(array('name' => 'login'));
				$this->user->add('roles', $role);
				
			}
			else
			{
				$_POST = array_intersect_key($post->as_array(), $_POST);
				
				$this->template->errors = $post->errors('user');
			}
		}
	}
	
	public function after()
	{
		parent::after();
		$this->template->view = $this->view;
	}

}
