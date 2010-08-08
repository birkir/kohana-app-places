<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_User extends ORM {
	
	protected $_primary_key = 'user_id';
	protected $_primary_val = 'name';
	
 	protected $_rules = array(
		'name' => array(
			'not_empty' => NULL
		)
	);
	
	public function logged_in()
	{
		if (Cookie::get('user_id', FALSE))
		{
			$user = $this->where('user_id', '=', Cookie::get('user_id', 0))->find();
			
			if ($user->loaded())
			{
				return TRUE;
			}
			else
			{
				Cookie::delete('user_id');
			}
		}
		
		return FALSE;
	}
	
	public function login($email=NULL,$password=NULL)
	{
		$user = $this->where('email', '=', $email)
		->where('password', '=', $password)
		->find();
		
		if ($user->loaded())
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
}