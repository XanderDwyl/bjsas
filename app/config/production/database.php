<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

return array(

	// Database Connections
	// --------------------------------------------------------------
	'connections' => array(
		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => $url["host"],
			'database'  => substr($url["path"], 1),
			'username'  => $url["user"],
			'password'  => $url["pass"],
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		)
	)

);
