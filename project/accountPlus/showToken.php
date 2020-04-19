<html>
    <section class = "text-center">
        Below is your id token. Do not share this with anyone as this is used to connect you to your account
    </section>
</html>

<?php
    $id = $_SESSION['id'];
?>

<html>
    <section class = "text-center">
        <button onclick=" showToken ()">show token</button>

        <div id="token" style="display: none;">
            <?=$id?>
        </div>
    </section>
</html>

<script>
    function showToken() 
    {
        var x = document.getElementById("token");
        if (x.style.display === "none")
        {
            x.style.display = "block";
        } 
        else 
        {
            x.style.display = "none";
        }
    }
</script>

<html>
        <section class = "text-center">
            <form method="post">
            <input type="submit" name="ResetToken"
                class="button" value="Reset Token" /> 
            </form>
        </section>
</html>



<?php
//checks if the button has been pressed and then calls then logs the user out
    if(array_key_exists('ResetToken', $_POST)) 
    { 
        require "db_connection.php";
        try
        {
            $newid = md5(uniqid(rand(), true));

            //create new id for AppUsers
            $stmt = $db->prepare(
                "UPDATE `AppUsers`
                SET id = :newid
                WHERE id = :id");
            $params = array(
                        ":id" => $id,
                        ":newid" => $newid);
            $stmt->execute($params);

            //create new id for CreditCardInfo
            $stmt = $db->prepare(
                "UPDATE `CreditCardInfo`
                SET id = :newid
                WHERE id = :id");
            $params = array(
                        ":id" => $id,
                        ":newid" => $newid);
            $stmt->execute($params);

            $_SESSION['id'] = $newid;

            header("Refresh:0");
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
    }
?>
