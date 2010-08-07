<?php defined('SYSPATH') or die('No direct script access.');


/**
 * Interface controller which does all the background working like find the
 * current language, set the project information and attach default template
 * to the request object.
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Interface extends Controller {
	
	public $language = "en-uk";

	public function before()
	{
		$this->template = new View('smarty:default');
		$this->config = Kohana::config("eat_is");
		
		// Project 
		View::set_global("project", (object) $this->config['project']);
		
		Cookie::$expiration = $this->config['cookies']['expiration'];
		Cookie::$domain = $this->config['cookies']['domain'];
		Cookie::$salt = $this->config['cookies']['salt'];
		
		// Languages
		$this->language = Cookie::get("language", $this->language);
		View::set_global("language", $this->language);
		I18n::$lang = $this->language;
		
		// Location
		$this->location = (object) array();
		$this->location->latitude = Cookie::get("lat", NULL);
		$this->location->longitude = Cookie::get("lng", NULL);
		View::set_global("location", $this->location);
		
		// Rounded corners
		View::set_global("corner", array("start" => "<div class=\"bt\"><div></div></div><div class=\"i1\"><div class=\"i2\"><div class=\"i3\">", "end" => "</div></div></div><div class=\"bb\"><div></div></div>"));
		
	}
	
	public function after()
	{
		$this->template->title = isset($this->title) ? $this->title : NULL;
		$this->request->response = $this->template;
	}

} // End Controller_Template

