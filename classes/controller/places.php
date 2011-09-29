<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Places extends Controller_Interface {

	public $title = 'Places';

	/**
	 * Find all categories order by index
	**/
	public function action_index()
	{
		$view = new View('misc/menu');

		$view->menu = ORM::factory('category')
		->order_by('index', 'ASC')
		->find_all();

		$view->prefix = 'places/category/';
		$this->template->back = "";
		$this->template->view = $view;
	}

	/**
	 * Get directions to place
	 */
	public function action_directions()
	{
		$place = $this->request->param('id');
		$view = new View('places/directions');

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
	public function action_category()
	{
		$category = $this->request->param('id');

		$view = new View('places/list');

		$category = ORM::factory('category')
		->where(is_numeric($category) ? 'category_id' : 'alias', '=', $category)
		->find();

		$view->items = $category->place
		->where('enabled', '=', 1)
		->where('removed', '=', 0)
		->find_all();

		$this->template->back = "places";

		$view->zip = $this->zip();

		$this->template->view = $view;
	}

	/**
	 * Find places in neighborhood
	 */
	public function action_neighborhood()
	{
		$place = new Model_Place();

		$this->template->view = new View('places/list');

		$this->template->view->zip = $this->zip();

		$distance = $place->select($place->near(Cookie::get("lat", 0), Cookie::get("lng", 0)));

		$this->template->view->items = $distance->order_by("distance", "ASC")->limit(10)->find_all();
	}

	/**
	* List all food types
	**/
	public function action_food_types()
	{
		$view = new View('misc/menu');

		$view->menu = ORM::factory('food')
		->order_by('title', 'ASC')
		->find_all();

		$view->prefix = 'places/food/';

		$this->template->view = $view;
	}

	/**
	 * Find places by food type
	 */
	public function action_food()
	{
		$food = $this->request->param('id');

		$view = new View('places/list');

		$view->zip = $this->zip();

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
	 * List all price ranges
	 */
	public function action_price_range()
	{
		$view = new View('misc/menu');

		$view->menu = (object) array(
			(object) array(
				'title' => '0 - 1000 ISK',
				'alias' => 'places/price/0-1000'
			),
			(object) array(
				'title' => '1000 - 2000 ISK',
				'alias' => 'places/price/1000-2000'
			),
			(object) array(
				'title' => '2000 - 3000 ISK',
				'alias' => 'places/price/2000-3000'
			),
			(object) array(
				'title' => '3000 - 4000 ISK',
				'alias' => 'places/price/3000-4000'
			),
			(object) array(
				'title' => '4000 - 5000 ISK',
				'alias' => 'places/price/4000-5000'
			)
		);

		$this->template->view = $view;
	}

	/**
	 * Find places by price range
	 */
	public function action_price()
	{
		$price = explode('-', $this->request->param('id'));

		$view = new View('places/list');

		$view->zip = $this->zip();

		$view->items = ORM::factory('place')
		->where('price_from', '>=', $price[0])
		->where('price_to', '<=', $price[1])
		->where('enabled', '=', 1)
		->where('removed', '=', 0)
		->order_by('price_from', 'ASC')
		->group_by('title')
		->limit(10)
		->find_all();

		$this->template->view = $view;
	}

	/**
	 * Get random place
	**/
	public function action_random()
	{
		$view = new View('places/default');

		$view->zip = $this->zip();

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

		$view = new View('places/fieldset');

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
	 * Find one place
	 */
	public function action_view()
	{
		$place = $this->request->param('id');

		$view = new View('places/default');

		$hour = new Model_Hour;

		$view->place = ORM::factory("place")
		->where(is_numeric($place) ? 'place_id' : 'alias', '=', $place)
		->where("enabled", "=", 1)
		->where("removed", "=", 0)
		->find();

		$view->zip = $this->zip();

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

		$view->map = "";

		$this->template->view = $view;
	}

	public function zip()
	{
		$xml = new SimpleXMLElement(file_get_contents(APPPATH.'media/xml/postnumer.xml'));
		$ret = array();
		foreach($xml->Postnumer as $zip)
		{
			if (isset($zip->Numer))
			{
				$ret[(int) $zip->Numer] = (string) $zip->Heiti;
			}
		}

		return $ret;
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
