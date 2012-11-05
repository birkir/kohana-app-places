<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Places model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Place extends ORM {

	/**
	 * @var Has many relationship
	 */
	protected $_has_many = array(
		'foods' => array(
			'through' => 'places_foods',
			'foreign_key' => 'place_id',
			'far_key' => 'food_id'
		),
		'categories' => array(
			'through' => 'places_categories',
			'foreign_key' => 'place_id',
			'far_key' => 'category_id'
		),
		'hours' => array(),
		'rating' => array('model' => 'Rating')
	);

	/**
	 * @var Belongs to relationship
	 */
	protected $_belongs_to = array(
		'zip' => array('model' => 'Zip')
	);

	/**
	 * @var Rules for creation of place
	 */
 	protected $_rules = array(
		'title' => array(
			'not_empty' => NULL
		),
		'website' => array(),
		'email' => array(),
		'phone' => array(),
		'price_from' => array(
			'not_empty' => NULL
		),
		'price_to' => array(
			'not_empty' => NULL
		),
		'description' => array(),
		'street_name' => array(
			'not_empty' => NULL
		),
		'street_number' => array(),
		'zip' => array(
			'not_empty' => NULL,
			'digit' => NULL
		)
	);

 	/**
 	 * @var Labels for form fields
 	 */
	protected $_labels = array(
		"price_from" => "price from",
		"price_to" => "price to",
		"street_name" => "street name",
		"street_number" => "street number"
	);

	/**
	 * Creates an array to use in DB::select statement, it calculates distance
	 * from each place to given location in kilometers.
	 *
	 *	@param	float  Latitude
	 *	@param	float  Longitude
	 *	@return	array  Select statement
	 */
	public function near($latitude = 0.000, $longitude = 0.000)
	{
		// round query
		$query = '(((acos(sin(('.$latitude.' * pi() / 180))'
		       . ' * sin((`latitude` * pi() / 180))'
		       . ' + cos(('.$latitude.' * pi() / 180))'
		       . ' * cos((`latitude` * pi() / 180))'
		       . ' * cos((('.$longitude.' - `longitude`)'
		       . ' * pi() / 180))))'
		       . ' * 180 / pi()) * 60 * 1.1515 * 1.609344)';

		// add to select container
		$this->select(array(DB::expr($query), 'distance'));

		// return self
		return $this;
	}

} // End Place
