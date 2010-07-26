<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Hour model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Hour extends ORM {
	
	protected $_primary_key = 'hour_id';
	protected $_primary_val = 'day_of_week';
 
 	protected $_rules = array(
		'day_of_week' => array(
			'not_empty' => NULL
		)
	);
	
	public function pretty_hour($source=NULL)
	{
		$days = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
		
		$hours = array();
		$items = array();
		$ret = array();
		
		foreach ($source as $item)
		{
			if (strlen($item->open) == 3)
			{
				$item->open = "0".$item->open;
			}
			if (strlen($item->close) == 3)
			{
				$item->close= "0".$item->close;
			}
			$hours[$item->day_of_week][] = array("open" => $item->open, "close" => $item->close);
		}
		
		foreach ($hours as $k => $h)
		{
			if (isset($items[md5(json_encode($h))]))
			{
				$items[md5(json_encode($h))]['days'][] = $k;
			}
			else
			{
				$items[md5(json_encode($h))] = array("hours" => $h, "days" => array($k));
			}
		}
		
		foreach ($items as $item)
		{
			$x = array();
			
			foreach ($item['days'] as $_key => $_item)
			{
				if ($_key > 0 AND $item['days'][$_key-1] == $_item - 1)
				{
					$x[] = $_item;
				}
				else
				{
					if (count($x) > 0)
					{
						$s = intval($x[0].count($x));
						if (count($x) == 1)
						{
							$x = __($days[$x[0]]);
						}
						elseif (count($x) > 1)
						{
							$x = __($days[$x[0]])." - ".__($days[$x[count($x)-1]]);
						}
						$ret[$s] = array("days" => $x, "hours" => $item['hours']);
					}
					$x = array($_item);
				}
			}
			if (count($x) > 0)
			{
				$s = intval($x[0].count($x));
				if (count($x) == 1)
				{
					$x = __($days[$x[0]]);
				}
				elseif (count($x) > 1)
				{
					$x = __($days[$x[0]])." - ".__($days[$x[count($x)-1]]);
				}
				$ret[$s] = array("days" => $x, "hours" => $item['hours']);
			}
		}
		ksort($ret);
		return $ret;
	}
	
} // End Model_Hour