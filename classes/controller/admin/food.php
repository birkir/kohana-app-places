<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin_Food controller
 *
 * @package    Eat.is
 * @category   Admin
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin_Food extends Controller_Admin {

	public $title = "Food";
	public $food, $view;
	
	public function before()
	{
		parent::before();
		$this->food = ORM::factory('food');
	}
	
	public function action_index()
	{
		$this->view = new View('smarty:admin/list');
		
		$this->view->fields = array(
			'alias' => 'Alias'
		);
		
		$count = $this->food->where('removed', '=', 0)->find_all()->count();
		
		$this->view->pagination = Pagination::factory(array(
			'view'           => 'admin/pagination',
			'total_items'    => $count,
			'items_per_page' => $this->items_per_page,
		));
		
		$this->view->control = Inflector::singular($this->request->controller);
		
		$this->view->items = $this->food
		->order_by('food_id', 'ASC')
		->limit($this->view->pagination->items_per_page)
		->offset($this->view->pagination->offset)
		->find_all();
	}
	
	public function action_edit($id=0)
	{
		$this->view = new View('smarty:admin/food');
		$this->view->food = ORM::factory('food', $id);
		
		if ($_POST)
		{
			if ($this->view->food->values($_POST)->check())
			{
				$this->view->food->save();
			}
			else
			{
				$this->view->errors = $this->view->food->validate()->errors('food');
				$_POST['food_id'] = $this->view->food->food_id;
				$this->view->food = (object) $_POST;
			}
		}
	}
	
	public function action_new()
	{
		$this->view = new View('smarty:admin/food');
		$this->view->food = ORM::factory('food');
		
		if ($_POST)
		{
			if ($this->view->food->values($_POST)->check())
			{
				$this->view->food->save();
			}
			else
			{
				$this->view->errors = $this->view->food->validate()->errors('food');
				$_POST['food_id'] = $this->view->food->food_id;
				$this->view->food = (object) $_POST;
			}
		}
	}
	
	public function after()
	{
		parent::after();
		$this->template->view = $this->view;
	}

}

