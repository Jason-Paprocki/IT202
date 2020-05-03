<?php
    //ini_set('display_errors',1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    
    require "db_connection.php";
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
    
    //check if the email is in use already
    try
    {        
        $stmt = $db->prepare("SELECT email from `AppUsers` where email = :email ");
        $params = array(":email"=> $email);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
    }
    catch(Exception $e)
    {
		echo $e->getMessage();
		exit();
    }
    if ($result[0]["email"] != NULL)
    {
        echo "<script type='text/javascript'>alert('Email in use');</script>";
        exit();
    }
        
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
