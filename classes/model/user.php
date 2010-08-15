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
	protected $_primary_val = 'title';
	
	protected $_has_many = array
	(
		'roles' => array(
			'through' => 'roles_users',
			'foreign_key' => 'user_id',
			'far_key' => 'role_id'
		)
	);
	
 	protected $_rules = array
	(
		'title' => array
		(
			'not_empty' => NULL,
		),
		'username' => array
		(
			'not_empty'		=> NULL,
			'min_length'	=> array(4),
			'max_length'	=> array(32),
			'regex'			=> array('/^[-\pL\pN_.]++$/uD'),
		),
		'password' => array
		(
			'not_empty'		=> NULL,
			'min_length'	=> array(5),
			'max_length'	=> array(42),
		),
		'email'				=> array
		(
			'not_empty'		=> NULL,
			'min_length'		=> array(4),
			'max_length'		=> array(127),
			'validate::email'	=> NULL,
		)
	);
	
	protected $_callbacks = array
	(
		'username'			=> array('username_available'),
		'email'					=> array('email_available'),
	);
	
	private $user;
	
	public function validate_create(& $array) 
	{
		$array = Validate::factory($array)
			->rules('title', $this->_rules['title'])
			->rules('password', $this->_rules['password'])
			->rules('username', $this->_rules['username'])
			->rules('email', $this->_rules['email'])
			->rule('password_confirm', 'Model_User::match_password')
			->filter('username', 'trim')
			->filter('email', 'trim')
			->filter('password', 'trim')
			->filter('password_confirm', 'trim')
			->filter('password', 'Model_User::hash_password');
			
		foreach ($this->_callbacks as $field => $callbacks)
		{
			foreach ($callbacks as $callback){
				$array->callback($field, array($this, $callback));
			}
		}
		
		return $array;
	}
	
	/**
	 * Checks if password matches password_confirm
	 *
	 * @param	string		Base password
	 * @param	string		Password to match
	 * @return	bool
	 */
	public static function match_password($password=NULL, $match=NULL)
	{
		$encrypt = Encrypt::instance('default');
		
		if ($encrypt->decode($password) == $match)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * Creates a hashed password from a plaintext password
	 *
	 * @param	string		Password to hash
	 * @return	string		Hashed password string
	 */
	public static function hash_password($password=NULL)
	{
		$encrypt = Encrypt::instance('default');
		
		return $encrypt->encode($password);
	}
	
	/**
	 * Check if user can change its email to this one
	 *
	 * @param	Validate		Validate object
	 * @param	string		Field name
	 */
	public function email_change(Validate $array, $field)
	{
		$exists = (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where('email',   '=',   $array[$field])
			->where('id',     '!=',   $this->id)
			->execute($this->_db)
			->get('total_count');
			
		if ($exists)
		{
			$array->error($field, 'email_change', array($array[$field]));
		}
	}
	
	/**
	 * Does the reverse of unique_key_exists() by triggering error if username exists
	 * Validation Rule
	 *
	 * @param	Validate		Validate object
	 * @param	string		Field name
	 * @param	array			Current validation errors
	 * @return	array
	 */
	public function username_available(Validate $array, $field)
	{
		if ($this->unique_key_exists($array[$field]))
		{
			$array->error($field, 'username_available', array($array[$field]));
		}
	}
	
	/**
	 * Does the reverse of unique_key_exists() by triggering error if email exists
	 * Validation Rule
	 *
	 * @param	Validate		Validate object
	 * @param	string		Field name
	 * @param	array			Current validation errors
	 * @return	array
	 */
	public function email_available(Validate $array, $field)
	{
		if ($this->unique_key_exists($array[$field]))
		{
			$array->error($field, 'email_available', array($array[$field]));
		}
	}
	
	/**
	 * Tests if a unique key value exists in the database
	 *
	 * @param	mixed			Value to test
	 * @return	bool
	 */
	public function unique_key_exists($value)
	{
		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($this->unique_key($value), '=', $value)
			->execute($this->_db)
			->get('total_count');
	}
	
	/**
	 * Allows a model use both email and username as unique identifiers for login
	 *
	 * @param	string		Unique value
	 * @return	string		Field name
	 */
	public function unique_key($value)
	{
		return Validate::email($value) ? 'email' : 'username';
	}
	
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
		$encrypt = Encrypt::instance('default');
		
		$user = ORM::factory('user');
		
		$user->or_where_open()
		->or_where('email', '=', $login)
		->or_where('username', '=', $login)
		->or_where_close()
		->and_where('enabled', '=', 1)
		->and_where('removed', '=', 0)
		->find();
		
		if ($user->has('roles', ORM::factory('role', array('name' => 'login'))))
		{
			if ($encrypt->decode($user->password) == $password)
			{
				$user->logins = $user->logins + 1;
				$user->save();
				Cookie::set('login', $user->user_id, time() + $lifetime);
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	/**
	 * Logout, delete cookie and redirect
	 */
	public function logout()
	{
		Cookie::delete('login');
		
		return TRUE;
	}
	
	/**
	 * Check if user is logged in and get user details while at it.
	 *
	 * @param	string	Role to check for
	 * @return	bool/object
	 */
	public function logged_in($role=NULL)
	{
		$encrypt = Encrypt::instance('default');
		
		$user_id = Cookie::get('login', FALSE);
		
		if ( ! isset($this->user) AND $user_id)
		{
			$user = ORM::factory('user', $user_id);
			
			$this->user = $user
			->where('enabled', '=', 1)
			->where('removed', '=', 0)
			->find();
		}
		
		if ($user_id AND $this->user->loaded())
		{
			if ($encrypt->decode($this->user->password) == $encrypt->decode($user->password))
			{
				if ( ! empty($role))
				{
					if (is_array($role))
					{
						foreach ($role as $_role)
						{
							$_role = ORM::factory('role', array('name' => $_role));
							
							if ( ! $user->has('roles', $_role))
							{
								return FALSE;
							}
						}
					}
					else
					{
						$role = ORM::factory('role', array('name' => $role));
						if ( ! $user->has('roles', $role))
						{
							return FALSE;
						}
					}
				}
				
				return $user->user_id;
			}
		}
		
		return FALSE;
	}
	
	
}