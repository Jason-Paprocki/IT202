<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    //top of the page
    require "accountPlus/headers.html";
    
    
    if (isset($_SESSION["email"]))
    {
        //checks if the user has cookies set and then allows them to logout
        require "accountPlus/logoutButton.php";
    }

    
    if ($_SESSION["redirect"] == "login")
    {
        echo "Thank you for logging in";
    }
    elseif ($_SESSION["redirect"] == "register") 
    {
        echo "Thank you for registering";
    }
    else
    {
        exit("Please Log in");
    }
    require "accountPlus/changeEmail.php";
    require "accountPlus/changePassword.php";
    
    try
    {
        require "db_connection.php";
        $id = $_SESSION['id'];
        //checks if there is already a card
        $stmt = $db->prepare(
            "SELECT cardNum 
            from `CreditCardInfo` 
            where id = :id LIMIT 1");
        $params = array(":id"=> $id);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $cardNum = $result["cardNum"];
    }
    
    catch(Exception $e)
    {
		echo $e->getMessage();
		exit();
    }
    
    if ($cardNum == NULL)
    {
        if (isset($_SESSION["email"]))
        {
            require "accountPlus/createCreditCard.php";
        }
        else
        {
            echo "You must log in first";
        }
    }
    else 
    {
        require "accountPlus/showOrResetCreditCard.php";
    }

    //show token
    require "accountPlus/showToken.php";
?>