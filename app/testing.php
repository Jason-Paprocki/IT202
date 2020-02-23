<?php
//this is check_db.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("config.php");
echo "DBUser: " .  $dbuser;
echo "\n\r";

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";

try{
	$db = new PDO($connection_string, $dbuser, $dbpass);
	echo "Should have connected";
	$stmt = $db->prepare("CREATE TABLE `AppUsers` (
				`email` varchar(100) not null unique,
                `password` varchar(64) not null unique,
				`created` timestamp default current_timestamp,
				`endTime` timestamp default current_timestamp,
                `timeLeft` boolean
				)"
			);
	$stmt->execute();
	echo var_export($stmt->errorInfo(), true);
}
catch(Exception $e){
	echo $e->getMessage();
	exit("It didn't work");
}

?>