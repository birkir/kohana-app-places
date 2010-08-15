<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin_Places controller
 *
 * @package    Eat.is
 * @category   Admin
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin_Places extends Controller_Admin {
	
	public $title = "Places";
	public $place, $view;
	
	public function before()
	{
		parent::before();
		$this->place = ORM::factory('place');
	}
	
	public function action_index()
	{
		$this->view = new View('smarty:admin/list');
		
		$this->view->fields = array(
			'alias' => 'Alias',
			'street_name' => 'Street name',
			'street_number' => 'No.',
			'zip' => 'Zip code'
		);
		
		$count = $this->place->where('removed', '=', 0)->find_all()->count();
		
		$this->view->pagination = Pagination::factory(array(
			'view'           => 'admin/pagination',
			'total_items'    => $count,
			'items_per_page' => $this->items_per_page,
		));
		
		$this->view->control = Inflector::singular($this->request->controller);
		
		$this->view->items = $this->place
		->order_by('place_id', 'ASC')
		->limit($this->view->pagination->items_per_page)
		->offset($this->view->pagination->offset)
		->find_all();
	}
	
	public function action_new()
	{
		$this->view = new View('smarty:admin/places');
		$this->view->place = ORM::factory('place', 0);
		$this->view->zips = $this->zips();
		$this->view->days = $this->days();
	}
	
	public function action_edit($id=0)
	{
		$this->view = new View('smarty:admin/places');
		$this->view->place = ORM::factory('place', $id);
		$this->view->zips = $this->zips();
		$this->view->days = $this->days();
		$this->view->title = $this->view->place->title;
		// get all food the place has
		$food = array();
		foreach ($this->view->place->foods->find_all() as $item)
		{
			$food[] = $item->title;
		}
		$this->view->food = implode(", ", $food);
		
		// get all categories the place is in
		$categories = array();
		foreach ($this->view->place->categories->find_all() as $item)
		{
			$categories[] = $item->title;
		}
		$this->view->categories = implode(', ', $categories);
		
		// if post
		if ($_POST)
		{
			$place = ORM::factory('place', $id);
			
			if ($place->values($_POST)->check())
			{
				$place->save();
				
				// parse foods
				$foods = array();
				foreach (explode(',', $_POST['food']) as $item)
				{
					$food = ORM::factory('food')->where('title', '=', trim($item))->find();
					$foods[] = $food->food_id;
					
					if ($food->loaded() AND !$place->has('foods', $food))
					{
						$place->add('foods', $food);
					}
				}
				$del = DB::delete('places_food');
				foreach ($foods as $f){
					$del = $del->where('food_id', '!=', $f);
				}
				$del = $del->where('place_id', '=', $place->place_id)->execute();
				
				// parse categories
				$categories = array();
				foreach (explode(',', $_POST['categories']) as $item)
				{
					$category = ORM::factory('category')->where('title', '=', trim($item))->find();
					$categories[] = $category->category_id;
					
					if ($category->loaded() AND !$place->has('categories', $category))
					{
						$place->add('categories', $category);
					}
				}
				$del = DB::delete('places_categories');
				foreach ($categories as $c){
					$del = $del->where('category_id', '!=', $c);
				}
				$del = $del->where('place_id', '=', $place->place_id)->execute();
				
				// parse hours
				$hours = array();
				if (isset($_POST['hour']))
				{
					foreach($_POST['hour'] as $hour_id => $item)
					{
						$hours[] = $hour_id;
						$hour = ORM::factory('hour', $hour_id);
						$hour->open = str_replace(':', '', $item['open']);
						$hour->close = str_replace(':', '', $item['close']);
						$hour->day_of_week = $item['day'];
						$hour->save();
					}
				}
				$del = DB::delete('hours');
				foreach ($hours as $h)
				{
					$del = $del->where('hour_id', '!=', $h);
				}
				$del = $del->where('place_id', '=', $place->place_id)
				->execute();
				
				// add new hours
				if (isset($_POST['new_hour']))
				{
					$_h = $_POST['new_hour'];
					foreach($_h['day'] as $k => $item)
					{
						$hour = ORM::factory('hour');
						$hour->open = str_replace(':', '', $_h['open'][$k]);
						$hour->close = str_replace(':', '', $_h['close'][$k]);
						$hour->day_of_week = str_replace(':', '', $_h['day'][$k]);
						$hour->place_id = $place->place_id;
						$hour->save();
					}
				}
				
				$this->request->redirect('/admin/places/edit/'.$place->place_id);
				
			}
			else
			{
				$this->view->errors = $place->validate()->errors('place');
				$this->view->place = (object) array(
					'place_id' => $place->place_id,
					'hours' => $this->view->place->hours
				);
				
				foreach($_POST as $key => $val)
				{
					$this->view->place->$key = $val;
				}
			}
		}
	}
	
	public function action_delete()
	{
	
	}
	
	/**
	 * Find all food and return as JSON array
	 *
	 * @param	string	Query
	 */
	public function action_food()
	{
		$q = isset($_REQUEST['term']) ? strtolower($_REQUEST['term']) : NULL;
		
		$this->json = TRUE;
		
		$this->food = ORM::factory('food')
		->order_by('title', 'ASC')
		->find_all();
		
		$food = array();
		
		foreach ($this->food as $item)
		{
			if (!empty($q) AND strpos(strtolower($item->title), $q) !== FALSE)
			{
				$food[] = array("id" => $item->food_id, "label" => $item->title, "value" => $item->title);
			}
			
			if (count($food) > 11)
			{
				break;
			}
		}
		$this->request->response = json_encode($food);
	}
	
	/**
	 * Find all categories and return as JSON array
	 */
	public function action_categories()
	{
		$this->json = TRUE;
		
		$this->category = ORM::factory('category')
		->order_by('index', 'ASC')
		->find_all();
		
		$categories = array();
		
		foreach ($this->category as $item)
		{
			$categories[] = array("id" => $item->category_id, "label" => $item->title, "value" => $item->title);
		}
		$this->request->response = json_encode($categories);
	}
	
	/**
	 * Get all days and return as JSON array
	 */
	public function action_days()
	{
		$this->json = TRUE;
		
		$days = $this->days();
		$this->request->response = json_encode($days);
	}
	
	/**
	 * Define days
	 */
	public function days()
	{
		return array(
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thirsday',
			'Friday',
			'Saturday',
			'Sunday'
		);
	}
	
	/**
	 * Get all zips from xml sheet
	 * @see http://www.postur.is/desktopdefault.aspx/tabid-145/
	 
	 * @return	array		Array of zips
	 */
	public function zips()
	{
		$xml = new SimpleXMLElement(file_get_contents(APPPATH.'resources/xml/postnumer.xml'));
		
		$skip = array(102,271,301,302,311,371,401,451,
						  471,531,541,551,566,621,641,681,
						  701,781,801,802,851,861,871,902);
		$zips = array();
		
		foreach($xml->Postnumer as $zip)
		{
			if (isset($zip->Numer) AND !in_array((int) $zip->Numer, $skip))
			{
				$zips[(int) $zip->Numer] = (string) $zip->Heiti;
			}
		}
		
		return $zips;
	}
	
	public function after()
	{
		parent::after();
		$this->template->view = $this->view;
	}
}
