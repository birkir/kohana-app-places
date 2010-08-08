<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin controller which does login, list actions to do and other
 * administrative things .
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin extends Controller_Interface {
	
	public $title = 'Admin';
	
	public function action_index()
	{
		$user = new Model_User;
		
		if (!$user->logged_in())
		{
			$this->template = Request::factory('admin/login')->execute()->response;
		}
	}
	
	public function action_login()
	{
		$user = new Model_User;
		
		$view = new View('smarty:users/login');
		
		if (isset($_POST['login']))
		{
			if ($user->login($_POST['email'], $_POST['password']))
			{
				$this->template = Request::factory('admin')->execute()->response;
			}
			else
			{
				$view->error = TRUE;
			}
		}
		
		$this->template->view = $view;
	}
	
	public function action_places($action=NULL)
	{
		$this->template = Request::factory('places/'.$action)->execute()->response;
	}
	
	public function action_users($action=NULL)
	{
		$this->template = Request::factory('users/'.$action)->execute()->response;
	}
	
	public function action_food($action=NULL)
	{
		
	}
	
	public function action_categories($action=NULL)
	{
		
	}
	
}