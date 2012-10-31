<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Handles all media the website will ever have to need. It minifies all
 * javascript and stylesheets. Then it compresses every file to gzip and outputs
 * it to the browser, if he accepts it.
 *
 * @package    Eat.is
 * @category   Controller
 * @author     Birkir Rafn Gudjonsson
 * @copyright  (c) 2010 Eat.is
 */
class Controller_Media extends Controller {

	public function action_serve()
	{
		$filepath = $this->request->param('file');

		$file = Kohana::find_file('media', $filepath, FALSE);

		if ( ! $file)
			throw new Kohana_Http_Exception_404;

		$this->response->body(file_get_contents($file));
		$this->response->headers('content-type', (string) File::mime_by_ext(pathinfo($file, PATHINFO_EXTENSION)));
		$this->response->headers('content-length', (string) filesize($file));
		$this->response->headers('last-modified', (string) date('r', filemtime($file)));
	}

} // End Media
