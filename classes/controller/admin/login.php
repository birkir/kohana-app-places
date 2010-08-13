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
                if (Auth::instance()->logged_in() != 0)
                {
                        Request::instance()->redirect('admin/places');
                }
                
                $this->template = new View('smarty:admin/login');
                
                if ($_POST)
                {
                        $user = ORM::factory('user');
                        
                        $status = $user->login($_POST);
                        
                        if ($status)
                        {
                                Request::instance()->redirect('admin/places');
                        }
                        else
                        {
                                $content->errors = $post->errors('login');
                        }
                }
        }
        
        public function action_logout()
        {
                Auth::instance()->logout();
                Request::instance()->redirect('admin/login');
        }

}

