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
	echo "Should have connected\n";
	

	 $stmt = $db->prepare("INSERT INTO `Users`
                        (email) VALUES
                        (:email)
			CHARACTER SET utf8 COLLATE utf8_general_ci"");
    
        $params = array(":email"=> 'email1@email.com');
        $stmt->execute($params);
        
	echo var_export($stmt->errorInfo(), true);
}
catch(Exception $e){
	echo $e->getMessage();
	exit("It didn't work");
}

?>

