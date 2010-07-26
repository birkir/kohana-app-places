<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Category model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Category extends ORM {
	
	protected $_primary_key = 'category_id';
	protected $_primary_val = 'title';
 
 	protected $_rules = array(
		'title' => array(
			'not_empty' => NULL
		)
	);
	
} // End Model_Category