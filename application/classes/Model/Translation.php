<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Translation model
 *
 * @package    Eat.is
 * @category   Models
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Model_Translation extends ORM {

	private $_translation_table = array();

 	protected $_belongs_to = array(
		'language' => array()
	);

 	public function translate($key = NULL, $model = NULL)
 	{
 		if ( ! isset($this->_translation_table[$model]))
 		{
 			$this->_translation_table[$model] = ORM::factory('Language', array('code' => I18n::$lang))
 			->translations
 			->where('model', '=', ucfirst($model))
 			->find_all()
 			->as_array('key', 'string');
 		}

 		return isset($this->_translation_table[$model][$key]) ? $this->_translation_table[$model][$key] : $key;
 	}
}