<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_User extends Model_Auth_User {
	
	protected $_primary_key = 'user_id';
	
	/**
	 * Log in with (username/email) and password
	 *
	 * @param	string	User login username/email
	 * @param	string	User login password
	 * @param	int		Cookie lifetime in seconds
	 * @return	bool
	 */
	public function login($login=NULL, $password=NULL, $lifetime=86400)
	{
		
	}
	
	/**
	 * Logout, delete cookie and redirect
	 */
	public function logout()
	{
		
	}
	
	/**
	 * Check if user is logged in and get user details while at it.
	 *
	 * @return	bool/object
	 */
	public function logged_in()
	{
		
	}
	
	
}