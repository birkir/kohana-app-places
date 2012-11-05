<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Rating model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Rating extends ORM {

	/**
	 * @var Belongs to relationship
	 */
	protected $_belongs_to = array(
		'place' => array('model' => 'Place')
	);

	/**
	 * Average rating
	 *
	 * @return float
	 */
	public function average()
	{
		$items = $this->find_all();
		$total = 0.000;
		$count = 0;

		foreach ($items as $item)
		{
			$total += $item->rating;
			$count++;
		}

		return $count == 0 ? 2.5 : $total / $count;
	}

} // End Rating
