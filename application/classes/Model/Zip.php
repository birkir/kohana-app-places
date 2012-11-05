<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Zip model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Zip extends ORM {

	/**
	 * @var Belongs to relationship
	 */
	protected $_belongs_to = array(
		'place' => array('model' => 'Place')
	);

} // End Zip
