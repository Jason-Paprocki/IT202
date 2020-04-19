<?php
    $lastDigitsOfCard = substr($cardNum, 12);
    $lastDigitsOfCard = 'xxxx-xxxx-xxxx-' . $lastDigitsOfCard;
    
    if(array_key_exists('ResetButton', $_POST)) 
    {
        $id = $_SESSION['id'];
        require "db_connection.php";
        try 
        {
            $stmt = $db->prepare(
                "UPDATE `CreditCardInfo`
                SET cardNum = NULL,
                expDate = NULL,
                CVV = NULL
                WHERE id = :id");
            $params = array(
                        ":id" => $id);
            $stmt->execute($params);
            $cardNum = NULL;
            header("Refresh:0");
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
    }
?>

<html>
    <section class = "text-center">
        <div>
        You have a Credit Card already
        </div>
        The card number is <?=$lastDigitsOfCard?>
    </section>

    <section class = "text-center">
        <form method="post">
        <input type="submit" name="ResetButton"
            class="button" value="Reset Card" /> 
        </form>
    </section>
</html>