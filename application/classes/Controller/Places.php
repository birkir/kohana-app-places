<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Places controller handles all restaurants in database, categorizes
 * them and such.
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2012 Eat.is
 */
class Controller_Places extends Controller_Base {

	/**
	 * @var Page title
	 */
	public $title = 'Places';

	/**
	 * Find all categories order by index
	 *
	 * @return void
	**/
	public function action_index()
	{
		// setup template and bind categories
		$this->template->view = View::factory('places/categories')
		->bind('categories', $categories);

		// get all categories by index
		$categories = ORM::factory('Category')
		->where('enabled', '=', 1)
		->where('deleted', '=', 0)
		->order_by('index', 'ASC')
		->find_all();
	}

	/**
	 * Find places by category
	 *
	 * @return void
	 */
	public function action_category()
	{
		// boot template
		$this->template->view = View::factory('places/list')
		->bind('items', $items);

		// find category by id or alias
		$category = ORM::factory('Category', array(
			is_numeric($this->request->param('id')) ? 'id' : 'alias' => $this->request->param('id')
		));

		// find items by cat
		$items = $category->places;

		// check if key is 'all'
		if ($this->request->param('id') == 'all')
		{
			$items = ORM::factory('Place');
		}

		// find all items
		$items = $items->where('enabled', '=', 1)
		->where('deleted', '=', 0)
		->order_by('title', 'ASC')
		->find_all();
	}

	/**
	 * Find places in neighborhood
	 *
	 * @return void
	 */
	public function action_neighborhood()
	{
		// check for address
		if ( ! Cookie::get('address', FALSE))
			return HTTP::redirect('location?redirect');

		// boot template
		$this->template->view = View::factory('places/list')
		->bind('items', $items);

		// find items
		$items = ORM::factory('Place')
		->near(Cookie::get('lat', 0.000), Cookie::get('lng', 0.000))
		->where('latitude', '!=', 0.000)
		->order_by('distance', 'ASC')
		->find_all();
	}

	/**
	* List all food types
	*
	* @return void
	**/
	public function action_foods()
	{
		// boot template
		$this->template->view = View::factory('places/foods')
		->bind('items', $items);

		// find items
		$items = ORM::factory('Food')
		->order_by('title', 'ASC')
		->find_all();
	}

	/**
	 * Find places by food type
	 *
	 * @return Request
	 */
	public function action_food()
	{
		// boot template
		$this->template->view = View::factory('places/list')
		->bind('items', $items);

		// find food by parameter
		$food = ORM::factory('Food', array(
			is_numeric($this->request->param('id')) ? 'id' : 'alias' => $this->request->param('id')
		));

		// check if place is loaded
		if ( ! $food->loaded())
		{
			// set 404 template
			$this->template->view = View::factory('misc/404');

			// set 404 status code
			return $this->response->status(404);
		}

		// find items
		$items = $food->places
		->where('enabled', '=', 1)
		->where('deleted', '=', 0)
		->find_all();
	}

	/**
	 * Get random place
	 *
	 * @return HTTP::redirect
	**/
	public function action_random()
	{
		// get random number
		$random = ORM::factory('Place')
		->order_by(DB::expr('RAND()'), 'ASC')
		->limit(1)
		->find()
		->get('id');

		$this->template->view = Request::factory('/places/details/'.$random)->execute()->body();
	}

	/**
	 * Find one place
	 *
	 * @return Request
	 */
	public function action_details()
	{
		// load maps
		$this->maps = TRUE;

		// boot template
		$this->template->view = View::factory('places/details')
		->bind('item', $item);

		// load place
		$item = ORM::factory('Place')
		->or_where_open()
			->or_where('id', '=', $this->request->param('id'))
			->or_where('alias', '=', $this->request->param('id'))
		->or_where_close()
		->where('enabled', '=', 1)
		->where('deleted', '=', 0)
		->find();

		// check if place is loaded
		if ( ! $item->loaded())
		{
			// set 404 template
			$this->template->view = View::factory('misc/404');

			// set 404 status code
			return $this->response->status(404);
		}
	}

	/**
	 * Just simple tests of places
	 *
	 * @return void
	**/
	public function action_tests()
	{
		$tests = array();
		$tests['total_places'] = ORM::factory('Place')
		->count_all();

		$tests['no_categories'] = ORM::factory('Place')
		->where(DB::select(DB::expr('COUNT(*)'))->from('places_categories')->where('place_id', '=', DB::expr('`id`')), '=', 0)
		->count_all();

		$tests['no_food'] = ORM::factory('Place')
		->where(DB::select(DB::expr('COUNT(*)'))->from('places_foods')->where('place_id', '=', DB::expr('`id`')), '=', 0)
		->count_all();

		$tests['avg_ratings_per_place'] = ORM::factory('Rating')
		->count_all() / $tests['total_places'];

		$tests['no_location'] = ORM::factory('Place')
		->where('latitude', '=', 0.0)
		->or_where('longitude', '=', 0.0)
		->count_all();

		echo Debug::vars($tests);

		exit;
	}

} // End Places
