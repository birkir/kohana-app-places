<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Language controller which gives the user ability to see all languages and
 * change it to something else than default. Language is stored with a regular
 * browser cookie.
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Language extends Controller_Base {

	/**
	 * @var Page title
	 */
	public $title = 'Language';

	/**
	 * @var Available languages
	 */
	public $languages = array(
		'en-uk' => 'English',
		'is-is' => 'Icelandic',
		'pl-pl' => 'Polish',
		'ru-ru' => 'Russian',
		'dk-dk' => 'Danish',
		'no-no' => 'Norway',
		'fo-fo' => 'Faroe Islands'
	);

	/**
	 * List all languages that are available. Note: Please do not show translations
	 * that are less than 75% translated.
	 *
	 * @return	View
	 */
	public function action_index()
	{
		// set view and languages
		$this->template->view = View::factory('language/list')
		->set('languages', (object) $this->languages);
	}

	/**
	 * Set language
	 *
	 * @param	string	Language code in ISO-639-1 format
	 * @return	object	Request
	 */
	public function action_set()
	{
		// get language parameter
		$lang = $this->request->param('id', $this->language);

		// check if requested language is available
		if (isset($this->languages[$lang]))
		{
			// set it as a cookie
			Cookie::set('language', $lang);
		}

		// redirect to language selection (for texts to reload)
		HTTP::redirect('/language');
	}

} // End Language
