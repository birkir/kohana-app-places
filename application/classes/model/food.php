<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Food model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Food extends ORM {
	
	protected $_table_name = 'food';
	protected $_primary_key = 'food_id';
	protected $_primary_val = 'title';
 
 	protected $_has_many = array(
		'place' => array(
			'through' => 'places_food',
			'foreign_key' => 'food_id',
			'far_key' => 'place_id'
		)
	);
 
 	protected $_rules = array(
		'title' => array(
			'not_empty' => NULL
		)
	);
	
} // End Model_Food
