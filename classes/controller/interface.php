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

	// Set default language
	public $language = 'en-uk';

	/**
	 * Do all the "before" work for the controller´s action
	 */
	public function before()
	{
		// Load template
		$this->template = new View('default');

		// Load Eat.is config
		$this->config = Kohana::$config->load("eat_is");

		// Cookie configuration
		Cookie::$expiration = $this->config['cookies']['expiration'];
		Cookie::$domain = $this->config['cookies']['domain'];
		Cookie::$salt = $this->config['cookies']['salt'];

		// Get language from cookie and assign to i18n
		$this->language = Cookie::get('language', $this->language);
		I18n::$lang = $this->language;
		// Get location altitude and longitude
		$this->location = (object) array(
			'latitude' => Cookie::get('lat', NULL),
			'longitude' => Cookie::get('lng', NULL)
		);

		// Fetch javascripts
		$this->template->js = Minify::factory('js')
		->set(file_get_contents(APPPATH.'media/js/eat.js'))
		->min();

		// Set global variables for template
		View::set_global('project', (object) $this->config['project']);
		View::set_global('language', $this->language);
		View::set_global('location', $this->location);
		View::set_global('corner', array('start' => '<div class="bt"><div></div></div><div class="i1"><div class="i2"><div class="i3">', 'end' => '</div></div></div><div class="bb"><div></div></div>'));

		// Render profiler template if requested
		if (isset($_GET['profiler']))
		{
			$this->template->profiler = new View('profiler/stats');
		}
	}

	/**
	 * Do all the "after" work and render out template
	 *
	 * @return	Request	Response
	 */
	public function after()
	{
		$this->template->title = isset($this->title) ? $this->title : NULL;
		$this->response->body($this->template->render());
	}

} // End Controller_Template

