<?php
        ini_set('display_errors',1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


    $id = $_POST['token'];

    date_default_timezone_set("America/New_York");
    try
    {
        require "db_connection.php";
        //checks if there is already a card
        $stmt = $db->prepare(
            "SELECT cardNum 
            from `CreditCardInfo` 
            where id = :id");
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
    //
    try
    {
        require "db_connection.php";
        //checks if there is already a card
        $stmt = $db->prepare(
            "SELECT endDate 
            from `AppUsers` 
            where id = :id");
        $params = array(":id"=> $id);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $endDate = $result["endDate"];
    }
    catch(Exception $e)
    {
		echo $e->getMessage();
		exit();
    }
    
    $currentDate = date("Y/m/d");
    $currentDate = new DateTime($currentDate);
    $endDate = new DateTime($endDate);
    //echo "$endDate and $currentDate";
    if($cardNum != NULL and ($endDate > $currentDate))
    {
        echo "1";
    }
    else
    {
        echo "0";
    }
?>