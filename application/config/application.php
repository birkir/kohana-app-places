<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'project' => array(
		'title' => 'Eat.is',
	),
	'cookies' => array(
		'domain' => 'eat.forritun.org', // Notice the first dot
		'expiration' => 86400 * 6 * 4,
		'salt' => 'foobarbaz0123456789', // Required to encrypt cookies
	),
	'google' => array(
		'maps' => '' // Required to display maps
	)
);
