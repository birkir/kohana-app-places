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

 	protected $_has_many = array(
		'places' => array('through' => 'places_foods')
	);

 	protected $_rules = array(
		'title' => array(
			'not_empty' => NULL
		)
	);

} // End Food
