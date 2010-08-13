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

	public function action_index()
	{
		
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

}
