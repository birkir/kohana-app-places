<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin controller handles template for admin interface
 *
 * @package    Eat.is
 * @category   Admin
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin_Login extends Controller_Admin {
	
	public function before()
	{
		parent::before();
		
		$this->user = ORM::factory('user');
	}
	
	public function action_index()
	{
		$this->template = new View('smarty:admin/login');
		
		if ($_POST)
		{
			if ($this->user->login($_POST['_u'], $_POST['_p']))
			{
				$this->request->redirect('admin/places');
			}
		}
		
	}
	
	public function action_logout()
	{
		if ($this->user->logout())
		{
			$this->request->redirect('admin/login');
		}
	}

}

