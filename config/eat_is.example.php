<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'project' => array(
		'title' => 'Eat.is',
	),
	'cookies' => array(
		'domain' => '.example.com', // Notice the first dot
		'expiration' => 86400 * 6 * 4,
		'salt' => '', // Required to encrypt cookies
	),
	'google' => array(
		'maps' => '' // Required to display maps
	)
);
