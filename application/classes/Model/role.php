<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Role extends ORM {
	
	protected $_table_name = 'roles';
	protected $_primary_key = 'role_id';
	protected $_primary_val = 'title';
	
	protected $_has_many = array
	(
		'users' => array(
			'through' => 'roles_users',
			'foreign_key' => 'role_id',
			'far_key' => 'user_id'
		)
	);
	
}