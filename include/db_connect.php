
<?php
$connection = new PDO( 'mysql:host=127.0.0.1;dbname=tcgempc', 'root', 'password' );
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn  = NEW mysqli('127.0.0.1', 'root', 'password', 'tcgempc');

if (!$conn) {
	echo "Connection failed!";
}


?>