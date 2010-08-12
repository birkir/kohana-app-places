<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Places extends Controller_Interface {

	public $title = 'Places';
	
	/**
	 * Find all categories order by index
	**/
	public function action_index()
	{
		$view = new View('smarty:misc/menu');
		
		$view->menu = ORM::factory('category')
		->order_by('index', 'ASC')
		->find_all();
		
		$view->prefix = 'places/category/';
		
		$this->template->back = "";
		
		$this->template->view = $view;
	}
	
	/**
	 * Find one place
	 */
	public function action_view($place=NULL)
	{
		$view = new View('smarty:places/default');
		
		$hour = new Model_Hour;
		
		$view->place = ORM::factory("place")
		->where(is_numeric($place) ? 'place_id' : 'alias', '=', $place)
		->where("enabled", "=", 1)
		->where("removed", "=", 0)
		->find();
		
		if (!$view->place->loaded())
		{
			throw new Kohana_Exception("Place not found");
		}
		
		$this->title = $view->place->title;
		
		$view->hours = $hour->pretty_hour(
			$view->place
			->hours
			->order_by("day_of_week", "asc")
			->order_by("close", "asc")
			->find_all()
		);
		
		// Get directions
		
		$res = file_get_contents("http://maps.google.com/maps/api/geocode/json?latlng=".urlencode($view->place->latitude.",".$view->place->longitude)."&sensor=false");
		$res = json_decode($res);
		
		$origin = Cookie::get("address", NULL);
		if ($res->status == "OK")
		{
			$destination = $res->results[0]->formatted_address;
		
			$res = file_get_contents("http://maps.google.com/maps/api/directions/json?origin=".urlencode($origin)."&destination=".urlencode($destination)."&sensor=false");
			$res = json_decode($res);
			
			if ($res->status == "OK")
			{
				$text_directions = array();
				$map_directions = "path=rgba:0x0000FF80,weight:5|";
				$map_directions_start = array(
					'lat' => $res->routes[0]->legs[0]->steps[0]->start_location->lat,
					'lng' => $res->routes[0]->legs[0]->steps[0]->start_location->lng,
				);
				foreach($res->routes[0]->legs[0]->steps as $item)
				{
					$text_directions[] = $item->html_instructions;
					$map_directions .= $item->start_location->lat.",".$item->start_location->lng."|";
					$map_directions_stop = array(
						'lat' => $item->start_location->lat,
						'lng' => $item->start_location->lng,
					);
				}
				$map_directions = "?markers=".$map_directions_start['lat'].",".$map_directions_start['lng'].",greena|".$map_directions_stop['lat'].",".$map_directions_stop['lng'].",greenb&".$map_directions;
				$center_point_lat = ($map_directions_start['lat']+$map_directions_stop['lat'])/2;
				$center_point_lng = ($map_directions_start['lng']+$map_directions_stop['lng'])/2;
				$view->map = "http://maps.google.com/staticmap".$map_directions."&size=412x300&key=".$this->config['google']['maps']."&center=".$center_point_lat.",".$center_point_lng;
			}
		}
		
		$this->template->view = $view;
	}
	
	/**
	 * Get directions to place
	 */
	public function action_directions($place=NULL)
	{
		$view = new View('smarty:places/directions');
		
		$view->place = ORM::factory("place")
		->where(is_numeric($place) ? 'place_id' : 'alias', '=', $place)
		->where("enabled", "=", 1)
		->where("removed", "=", 0)
		->find();
		
		if (!$view->place->loaded())
		{
			throw new Kohana_Exception("Place not found");
		}
	}
	
	/**
	 * Find places by category
	 */
	public function action_category($category=NULL)
	{
		$view = new View('smarty:places/list');
		
		$category = ORM::factory('category')
		->where(is_numeric($category) ? 'category_id' : 'alias', '=', $category)
		->find();
		
		$view->items = $category->place
		->where('enabled', '=', 1)
		->where('removed', '=', 0)
		->find_all();
		
		$this->template->back = "places";
		
		$this->template->view = $view;
	}
	
	/**
	 * Find places in neighborhood
	 */
	public function action_neighborhood()
	{
		$place = new Model_Place();
		
		$this->template->view = new View('smarty:places/list');
		
		$distance = $place->select($place->near(Cookie::get("lat", 0), Cookie::get("lng", 0)));
		
		$this->template->view->items = $distance->order_by("distance", "ASC")->find_all();
	}

        /**
         * List all food types
        **/
        public function action_food_types()
        {
                $view = new View('smarty:misc/menu');

                $view->menu = ORM::factory('food')
                ->order_by('title', 'ASC')
                ->find_all();

                $view->prefix = 'places/food/';

                $this->template->view = $view;
        }
	
	/**
	 * Find places by food type
	 */
	public function action_food($food=NULL)
	{
		$view = new View('smarty:places/list');
		
		$food = ORM::factory('food')
		->where(is_numeric($food) ? 'food_id' : 'alias', '=', $food)
		->find();
		
		if (!$food->loaded())
		{
			throw new Kohana_Exception("Food not found");
		}
		
		$view->items = $food->place
		->where('enabled', '=', 1)
		->where('removed', '=', 0)
		->find_all();
		
		$this->template->view = $view;
	}
	
	/**
	 * Get random place
	**/
	public function action_random()
	{
		$view = new View('smarty:places/default');
		
		$hour = new Model_Hour;
		
		$view->place = ORM::factory("place")
		->where("enabled", "=", 1)
		->where("removed", "=", 0)
		->order_by(DB::expr("RAND()"))
		->limit(1)
		->find();
		
		$this->title = $view->place->title;
		
		$view->hours = $hour->pretty_hour(
			$view->place
			->hours
			->order_by("day_of_week", "asc")
			->order_by("close", "asc")
			->find_all()
		);
		
		$this->template->view = $view;
	}
	
	/**
	 * Create new place
	**/
	public function action_new()
	{
		$food = new Model_Food;
		
		$view = new View('smarty:places/fieldset');
		
		$view->food = $food->find_all();
		
		if (isset($_POST['save']))
		{
			$place = ORM::factory('place');
			
			if ($place->values($_POST)->check())
			{
				$place_id = $place->save();
				
				// Add hours
				foreach ($this->parse_hours($_POST['opening_hours']) as $item)
				{
					foreach ($item['days'] as $day)
					{
						DB::insert('hours')
						->columns(array('place_id', 'day_of_week', 'open', 'close'))
						->values(array($place_id, $day, $item['open'], $item['close']))
						->execute();
					}
				}
				
				// Add categories
				foreach ($_POST['categories'] as $category)
				{
					DB::insert('places_categories')
					->columns(array('place_id', 'category_id'))
					->values(array($place_id, $category))
					->execute();
				}
				
				// Add food types
				foreach ($_POST['food_type'] as $food_type)
				{
					DB::insert('places_food')
					->columns(array('place_id', 'food_id'))
					->values(array($place_id, $food_type))
					->execute();
				}
				
				// Redirect to place
				$this->request->redirect('/places/view/'.$place_id);
			}
			else
			{
				$view->errors = $place->validate()->errors('place');
			}
		}
		
		$view->p = isset($_POST) ? $_POST : NULL;
		
		$this->template->view = $view;
	}
	
	/**
	 * Parse hours function
	 *
	 * @param	string	String to parse
	 * @return	array		Output array
	**/
	public function parse_hours($str='')
	{
		$day_strs = array(
			"mán" => 0, "þri" => 1, "mið" => 2, "fim" => 3, "fös" => 4, "lau" => 5, "sun" => 6,
			"mon" => 0, "tue" => 1, "wed" => 2, "thu" => 4, "fri" => 4, "sat" => 6
		);
		
		$exploders = array("og", ";", ",", ".", "|");
		
		$ret = array();
		$days = array();
		
		foreach($exploders as $exploder)
		{
			$_days = explode($exploder, $str);
			
			if (count($_days) > 1)
			{
				$days += $_days;
			}
		}
		
		foreach ($days as $day)
		{
			$_hours = array();
			
			preg_match_all("#([0-9]{2}(\:[0-9]{2})?)#s", $day, $output);
			
			if (isset($output[1]) AND count($output[1])==2)
			{
				$_hours['open'] = str_pad(str_replace(array(":", "."), "", $output[1][0]), 4, 0, STR_PAD_RIGHT);
				$_hours['close'] = str_pad(str_replace(array(":", "."), "", $output[1][1]), 4, 0, STR_PAD_RIGHT);
			}
			
			if (count($_hours) == 2)
			{
				$_days = array();
				$_name = array();
				
				foreach ($day_strs as $day_str => $day_key)
				{
					if (preg_match("#".$day_str."#s", $day))
					{
						$_days[] = $day_key;
						$_name[] = $day_str;
					}
				}
				
				if (count($_days) == 2)
				{
					$_first = strpos($day, $_name[0]) < strpos($day, $_name[1]) ? $_name[0] : $_name[1];
					$_last = $_first == $_name[0] ? $_name[1] : $_name[0];
					
					preg_match("#".$_first."(.*?)".$_last."#s", $day, $_to_str);
					
					if (isset($_to_str[1]) AND preg_match("#[to|til|\-]#s", $_to_str[1]))
					{
						$_days = range($_days[0],$_days[1]);
					}
				}
				
				if (preg_match("#(helg)#s", $day) OR preg_match("#(weekend)#s", $day))
				{
					$_days[] = 5;
					$_days[] = 6;
				}
				
				if (count($_days) > 0 )
				{
					$ret[] = array("hours" => $_hours, "days" => $_days);
				}
			}
			
		}
		
		return $ret;
	}

} // End Controller_Places
