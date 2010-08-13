<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin_Places controller
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin_Places extends Controller_Admin {

        public $title = "Places";
        private $place;
        
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
                $view = new View('smarty:admin/list');
                $view->items = $this->place->find_all();
                $this->template->view = $view;
        }
        
        public function action_new()
        {
                
        }
        
        public function action_edit()
        {
                
        }
        
        public function action_delete()
        {
                
        }

}
