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
	
	public function action_edit($id=0)
	{
		$this->view = new View('smarty:admin/users');
		$this->view->user = ORM::factory('user', $id);
		$this->view->roles = ORM::factory('role')
		->order_by('name', 'ASC')
		->find_all();
		
		$this->view->user_roles = array();
		foreach ($this->view->user->roles->find_all() as $role)
		{
			$this->view->user_roles[] = $role->role_id;
		}
		
		$this->view->my_roles = array();
		foreach ($this->_user->roles->find_all() as $role)
		{
			$this->view->my_roles[] = $role->role_id;
		}
		
		if ($_POST)
		{
			$encrypt = Encrypt::instance('default');
			
			if (empty($_POST['password']))
			{
				$_POST['password'] = $this->view->user->password;
			}else{
				$_POST['password'] = $encrypt->encode($_POST['password']);
			}
			$_POST['password_confirm'] = $_POST['password'];
			
			$_roles = isset($_POST['roles']) ? $_POST['roles'] : array();
			
			$post = $this->view->user->validate_change($_POST, $this->view->user->user_id);
			
			if ($post->check())
			{
				$this->view->user
				->values($post)
				->save();
				
				if (isset($_roles))
				{
					foreach ($_roles as $role => $do)
					{
						$role = new Model_Role(array('role_id' => $role));
						if ( ! $this->view->user->has('roles', $role))
						{
							$this->view->user->add('roles', $role);
						}
					}
				}
				foreach ($this->view->my_roles as $role)
				{
					$role = new Model_Role(array('role_id' => $role));
					
					if ( ! isset($_roles[$role->role_id]))
					{
						if ($this->view->user->has('roles', $role))
						{
							$this->view->user->remove('roles', $role);
						}
					}
				}
				
				$this->request->redirect('admin/users/edit/'.$id);
				
			}
			else
			{
				// $_POST = array_intersect_key($post->as_array(), $_POST);
				$this->template->errors = $post->errors('user');
			}
		}
	}
	
	public function action_new()
	{
		$this->view = new View('smarty:admin/users');
		$this->view->user = ORM::factory('user', 0);
		$this->view->roles = ORM::factory('role')
		->order_by('name', 'ASC')
		->find_all();
		$this->view->my_roles = array();
		foreach ($this->_user->roles->find_all() as $role)
		{
			$this->view->my_roles[] = $role->role_id;
		}
		
		if ($_POST)
		{
			$post = $this->user->validate_create($_POST);
			
			if ($post->check())
			{
				$this->user
				->values($post)
				->save();
				foreach ($_POST['roles'] as $role)
				{
					$role = new Model_Role(array('name' => $role));
					$this->user->add('roles', $role);
				}
				
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
