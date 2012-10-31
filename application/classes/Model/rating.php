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
	
	protected $_table_name = 'rating';
	protected $_primary_key = 'rating_id';
	protected $_primary_val = 'rating';
	
	protected $_belongs_to = array(
		'place' => array()
	);
	
	/**
	 * Calculate rating
	 */
	public function sum()
	{
		$i = 0;
		$total = 0;
		
		foreach ($this->find_all() as $item)
		{
			$total += $item->rating;
			$i++;
		}
		
		return $i > 0 ? $total/$i : 2.5;
	}
	
	/**
	 * Star generation
	 */
	public function stars($total=5)
	{
		$ret = array();
		
		$rating = $this->sum();
		
		for ($i=1; $i<=$total; $i++)
		{
			if ($i<=$rating)
			{
				$ret[] = 'full';
			}
			elseif ($i-0.25>=$rating AND $i-0.75<=$rating)
			{
				$ret[] = 'half';
			}
			elseif ($i>$rating)
			{
				$ret[] = 'empty';
			}
		}
		
		return $ret;
	}
	
} // End Model_Rating
