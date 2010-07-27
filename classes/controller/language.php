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
class Controller_Language extends Controller_Interface {

	public $title = "Language",
			 $languages = array(
				"en-uk" => "English",
				"is-is" => "Icelandic",
				"pl-pl" => "Polish",
				"ru-ru" => "Russian",
				"dk-dk" => "Danish",
				"no-no" => "Norway",
				"fo-fo" => "Faroe Islands"
			);
	
	/**
	 * List all languages
	 *
	 * @return	object	View
	 */
	public function action_index()
	{
		$view = new View('smarty:language/default');
		
		$view->languages = (object) $this->languages;
		
		$this->template->view = $view;
	}
	
	/**
	 * Set language
	 *
	 * @param	string	Language code in ISO-639-1 format
	 * @return	object	Request
	 */
	public function action_set($lang='en-uk')
	{
		if (isset($this->languages[$lang]))
		{
			Cookie::set("language", $lang);
		}
		
		$this->request->redirect("/language");
	}

} // End Controller_Language

