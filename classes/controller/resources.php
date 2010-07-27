<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Resources extends Controller {

	protected $_directory = "resources/";

	public function action_index()
	{
		$this->request->response = "404 File not found";
	}

	public function action_img($file='')
	{
		$this->passthru($file);
	}

	public function action_css($file='')
	{
		$this->passthru($file);
	}

	public function action_js($file='')
	{
		$this->passthru($file);
	}

	public function passthru($file='')
	{
		$this->file = APPPATH.$this->_directory.$this->request->action."/".$file;

		if (!is_file($this->file))
		{
			throw new Kohana_Exception('Image does not exist');
		}

		$this->request->headers['Content-Type'] = File::mime_by_ext($this->file);
		$this->request->headers['Content-length'] = filesize($this->file);

		$this->request->send_headers();

		$image = @ fopen($this->file, 'rb');
		if ($image)
		{
			fpassthru($image);
			exit;
		}
	}

} // End Controller_Resources
