<html>
    <section class = "text-center">
        <h1>Credit Card Info</h1>
        <form name="regform" id="myForm" method="POST" onsubmit="return verifyPasswords(this)">
            Enter the 16 digit Card Number: <input type="cardNumber" id="cardNumber" name="cardNumber" placeholder="xxxx xxxx xxxx xxxx"/>
            <br>
            Enter the CVV number: <input type="CVV" id="CVV" name="CVV" placeholder="xxx / xxxx"/>
            <br>
            Enter the expiration month: <input type="exp-month" id="expiration-month" name="expiration-month" placeholder="xx"/>
            <br>
            Enter the expiration year: <input type="exp-month" id="expiration-year" name="expiration-year" placeholder="20xx"/>
            <br>
            <input type="submit" value="Submit"/>
        </form>
    </section>
</html>

<?php

    //verify it  
    if(isset($_POST['cardNumber']) && isset($_POST['CVV']) && isset($_POST['expiration-month']) && isset($_POST['expiration-year']))
    {
    if(empty($_POST['expiration-year']) or (strlen($_POST['expiration-year']) != 4))
    {
        echo "<script type='text/javascript'>alert('Invalid Year');</script>";
    }
    else if(empty($_POST['expiration-month']) or (strlen($_POST['expiration-month']) != 2))
    {
        echo "<script type='text/javascript'>alert('Invalid month');</script>";
    }
    else if(empty($_POST['cardNumber']) or (strlen($_POST['cardNumber']) != 16))
    {
        echo "<script type='text/javascript'>alert('Invalid cardNumber');</script>";
    }
    else if(empty($_POST['CVV']) or (strlen($_POST['CVV']) > 4))
    {
        echo "<script type='text/javascript'>alert('Invalid CVV');</script>";
    }
    else 
    {
        $id = $_SESSION['id'];
        $cardNumber = $_POST['cardNumber'];
        $CVV = $_POST['CVV'];
        $expDate = $_POST['expiration-month'] . '-' . $_POST['expiration-year'];
        
        require "db_connection.php";
        try 
        {
            $stmt = $db->prepare(
                "UPDATE `CreditCardInfo`
                SET cardNum = :cardNumber,
                expDate = :expDate,
                CVV = :CVV
                WHERE id = :id");
            $params = array(
                        ":id" => $id,   
                        ":cardNumber" => $cardNumber,
                        ":expDate" => $expDate,
                        ":CVV" => $CVV);
            $stmt->execute($params);
            header("Refresh:0");
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
    }

    }
?>