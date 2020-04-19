<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    require "registerPlus/header.html";

if(	   isset($_POST['email']) 
	&& isset($_POST['password'])
	&& isset($_POST['confirm'])
    )
    
    {
    $email = $_POST['email'];
	$pass = $_POST['password'];
    $conf = $_POST['confirm'];
    $id = md5(uniqid(rand(), true));
    $endDate = date_create('1000-01-01');
    $endDate = $endDate -> format('Y-m-d');
    if($pass == $conf)
    {
		echo "All good, 'registering user'";
	}
	else{
		echo "What's wrong with you? Learn to type";
		exit();
	}
	//let's hash it
    $pass = password_hash($pass, PASSWORD_BCRYPT);

	//it's hashed
	require "db_connection.php";
    
    try
    {        
        $stmt = $db->prepare("INSERT INTO `AppUsers`
                        (id, email, password, endDate) VALUES
                        (:id, :email, :password,:endDate)");
        $params = array(":id" => $id,
                        ":email"=> $email, 
                        ":password"=> $pass,
                        ":endDate" => $endDate);
        $stmt->execute($params);
    }
    catch(Exception $e)
    {
		echo $e->getMessage();
		exit();
    }
    try
    {   
        $initZero = NULL;
        $stmt = $db->prepare("INSERT INTO `CreditCardInfo`
                        (id, cardNum, expDate, CVV) VALUES
                        (:id, NULL, NULL,NULL)");
        $params = array(":id" => $id);
        $stmt->execute($params);
	}
	catch(Exception $e){
		echo $e->getMessage();
		exit();
    }
    $_SESSION["email"] = ":email";
    $_SESSION["redirect"] = "register";
    $_SESSION["id"] = "$id";
    header("Location: account.php");
}
?>
