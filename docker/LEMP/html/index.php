<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "db";
$username = "user";
$password = "password";

try {
	// $dbhandle = mysqli_connect($servername, $username, $password)
	$dbhandle = new mysqli("db", "user", "password");
	echo "db connected";
} catch (\mysqli_sql_exception $e) {
	echo "error:" . $e->getMessage();
}
?>