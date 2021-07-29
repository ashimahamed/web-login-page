<?php
	// Enter Your Database Creds Here
	define('DB_SERVER', 'sg2.ashhost.in');
	define('DB_USERNAME', 'u344_k1s8yPs4hz');
	define('DB_PASSWORD', '0D+A6NFQ+lLVuaJJVy==9jNC');
	define('DB_NAME', 's344_abcde');

	// connect to MySQL database
	$mysql_db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if (!$mysql_db) {
		die("Error: Unable to connect " . $mysql_db->connect_error);
	}