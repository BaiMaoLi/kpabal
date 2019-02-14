<?php
	define('DB_NAME', 'jammin');
	define('DB_HOST', '70.32.29.156');
	define('DB_USER', 'michale900');
	define('DB_PASS', 'michale900');

	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>
