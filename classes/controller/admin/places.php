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
        private $place, $view;
        
        public function before()
        {
                parent::before();
                $this->place = ORM::factory('place');
        }

        public function action_index()
        {
                $this->template = Request::factory('admin/places/list')->execute()->response; 
        }
        
        public function action_list()
        {
                $this->view = new View('smarty:admin/list');
                $this->view->items = $this->place->find_all();
        }
        
        public function action_new()
        {
                $this->view = new View('smarty:admin/places');
                
        }
        
        public function action_edit()
        {
                
        }
        
        public function action_delete()
        {
                
        }
        
        public function after()
        {
                parent::after();
                $this->template->view = $this->view;
        }
}
