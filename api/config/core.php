<?php
	// error reporting config
	error_reporting(E_ALL);
 	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	$home_url = "http://localhost/backend-exercises/php_simple_restapi/api";

	$page = isset($_GET['page']) ? $_GET['page'] : 1;

	$records_per_page = 5;

	$from_page_num = ($page * $records_per_page) - $records_per_page;

?>