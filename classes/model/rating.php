<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Rating model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Rating extends Model {
	
	public function get($id=0)
	{
		$res = DB::select(
			array(DB::expr('SUM(`rating`)'), 'rating'),
			array(DB::expr('COUNT(*)'), 'total')
		)
		->from('rating')
		->where('restaurant_id', '=', $id)
		->where('removed', '=', 0)
		->as_object()
		->execute();
		
		return $res;
	}
} // End Model_Rating