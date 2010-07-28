<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Resources extends Controller {

	protected $_directory = "resources/";

	public function action_index()
	{
		$this->request->response = "404 File not found";
	}

	public function action_img($file='')
	{
		$file = APPPATH.$this->_directory.$this->request->action."/".$file;
		$this->passthru($file);
	}

	public function action_css($file='')
	{
		$file = APPPATH.$this->_directory.$this->request->action."/".$file;
		$file = $this->gzip($file);
		$this->passthru($file, true);
	}

	public function action_js($file='')
	{
		$file = APPPATH.$this->_directory.$this->request->action."/".$file;
		$file = $this->gzip($file);
		$this->passthru($file, true);
	}

	public function passthru($file='', $gzip=false)
	{
		if (!is_file($file))
		{
			throw new Kohana_Exception('File does not exist');
		}
		
		if ($this->request->accept_encoding('gzip') AND $gzip==true)
		{
			$this->request->headers['Content-Encoding'] = 'gzip';
		}
		
		$this->request->headers['Content-Type'] = File::mime_by_ext($file);
		$this->request->headers['Content-length'] = filesize($file);
		$this->request->headers['Last-Modified']  = date('r', filemtime($file));
		
		if (isset($cache))
		{
			$this->request->headers['Cache-Control'] = 'must-revalidate';
			$this->request->headers['Expires'] = gmdate("D, d M Y H:i:s", time() + 86400).' GMT';
		}
		
		$this->request->send_headers();
		
		$image = @ fopen($file, 'rb');
		if ($image)
		{
			fpassthru($image);
			exit;
		}
	}
	
	public function gzip($file='')
	{
		$this->cached = APPPATH.'cache/resources/'.md5_file($file);
		
		if (!is_file($file))
		{
			throw new Kohana_Exception('File does not exist');
		}
		
		$fh = fopen($this->cached, "w+");
		fwrite($fh, gzencode(file_get_contents($file)));
		fclose($fh);
		
		return $this->cached;
	}

} // End Controller_Resources
