<?php
    //ini_set('display_errors',1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
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
        echo " <section class = 'text-center'> <h2> Thank you for Logging in </h2> </section> ";
    }
    elseif ($_SESSION["redirect"] == "register") 
    {
        echo " <section class = 'text-center'> <h2> Thank you for Registering </h2> </section> ";
    }
    else
    {
        echo " <section class = 'text-center'> Please Log in</section> ";
        exit();
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
            echo " <section class = 'text-center'> You must log in first</section> ";
        }
    }
    else 
    {
        require "accountPlus/showOrResetCreditCard.php";
    }

    //show token
    require "accountPlus/showToken.php";
    
    try 
    {
        $stmt = $db->prepare("SELECT endDate from `AppUsers` where id = :id LIMIT 1");
    
        $params = array(":id"=> $id);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        exit();
    }
    $timeDisplay = $result["endDate"];
    if ( $timeDisplay != "1000-01-01")
    {
        echo " <section class = 'text-center'> This service is valid until $timeDisplay</section> ";
    }
    else
    {
        echo " <section class = 'text-center'> You have no valid time purchased</section> ";
    }
?>