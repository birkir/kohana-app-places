<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Base controller which does all the background working like find the
 * current language, set the project information and attach default template
 * to the request object.
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2012 Eat.is
 */
class Controller_Base extends Controller_Template {

	/**
	 * @var Language selected
	 */
	public $language = 'en-uk';

	/**
	 * @var Google Maps API
	 */
	public $maps = FALSE;

	/**
	 * @var Debug mode
	 */
	public $debug = FALSE;

	/**
	 * @var Require location set
	 */
	public $require_location = FALSE;

	/**
	 * Do all the "before" work for the controller´s action
	 * 
	 * @return void
	 */
	public function before()
	{
		// extend Kohana's before template function
		parent::before();

		// load application config
		$this->config = Kohana::$config->load('application');

		// cookie configuration
		Cookie::$expiration = $this->config['cookies']['expiration'];
		Cookie::$domain = $this->config['cookies']['domain'];

		// get language from cookie
		$this->language = Cookie::get('language', $this->language);

		// set language to kohana
		I18n::$lang = $this->language;

		// get location altitude and longitude from cookie
		$this->location = (object) array(
			'latitude' => Cookie::get('lat', NULL),
			'longitude' => Cookie::get('lng', NULL)
		);

		// initialize translation
		View::set_global('i18n', ORM::factory('Translation'));

		// determine debug mode
		$this->debug = $this->request->query('debug') !== NULL ? TRUE : FALSE;
	}

	/**
	 * Do all the "after" work and render out template
	 *
	 * @return void
	 */
	public function after()
	{
		// just want 
		if ( !  Request::current()->is_initial() OR Request::current()->is_ajax())
		{
			$this->template = $this->template->view;

			return parent::after();
		}

		// set class inherit values
		$this->template->maps = $this->maps;
		$this->template->debug = $this->debug;

		// check for location setter
		if ($this->require_location === TRUE AND ! Cookie::get('address', FALSE))
		{
			// redirect to set location
			HTTP::redirect('/location');
		}

		parent::after();
	}

} // End Base
