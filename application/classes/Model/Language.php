<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Language model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Language extends ORM {

 	protected $_has_many = array(
		'translations' => array()
	);

} // End Language
