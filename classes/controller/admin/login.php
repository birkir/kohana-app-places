<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin controller handles template for admin interface
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Admin_Login extends Controller_Admin {

        public function action_index()
        {
                $this->template = new View('smarty:admin/login');
        }

}

