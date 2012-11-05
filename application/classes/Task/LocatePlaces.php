<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_LocatePlaces extends Minion_Task
{
	protected $_options = array(
		'start_from' => 0
	);

	private function check_location($item)
	{
		if ($item->longitude == 0.0) {

			$query = urlencode($item->street_name.' '.$item->street_number.', '.$item->zip->id.' '.$item->zip->title);
			$raw = json_decode(file_get_contents('http://ja.is/kort/search_json/?q='.$query));

			if (isset($raw->map->items[0]) AND $raw->map->items[0]->has_coordinates)
			{
				$coords = $raw->map->items[0]->coordinates;

				$isn93 = new ISN93;
				$new_coords = $isn93->to_coords($coords->x, $coords->y);

				$item->alias = isset($raw->map->items[0]->cluster_key) ? $raw->map->items[0]->cluster_key : $item->alias;
				$item->longitude = $new_coords['longitude'];
				$item->latitude = $new_coords['latitude'];
				$item->save();
			}
		}
	}

	protected function _execute(array $params)
	{
		Minion_CLI::write("\n".'# Locate places in database by using ja.is API and convert to coordinate system.');
		Minion_CLI::write("# Starting from #".$params['start_from']."...\n");

		$places = ORM::factory('Place')
		->where('id', '>=', $params['start_from'])
		->order_by('id', 'ASC')
		->find_all();

		foreach ($places as $place)
		{
			$this->check_location($place);
			Minion_CLI::write('[proccessing] #'.$place->id);
			sleep(4);
		}
	}
}