<html>
    <section class = "text-center">
        Change Email
        <form name="regform" id="myForm" method="POST" onsubmit="return verifyPasswords(this)">
            <input type="email" id="email" name="email" placeholder="New Email"/>
            <br>
            <input type="email" id="confirm" name="confirm" placeholder="Confirm New Email"/>
            <br>
            <input type="submit" value="Change Email"/>
        </form>
    </section>
</html>


<?php
    if(
        isset($_POST['email'])
	&& isset($_POST['confirm'])
    )
    {
        $email = $_POST['email'];
        $conf = $_POST['confirm'];

        if($email == $conf)
        {
            $id = $_SESSION['id'];
            //it's hashed
            require "db_connection.php";
            try
            {
                $stmt = $db->prepare(
                    "UPDATE `AppUsers`
                    SET email = :email
                    WHERE id = :id");
                $params = array(
                            ":id" => $id,
                            ":email" => $email);
                $stmt->execute($params);
                echo "email has been changed";
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                exit();
            }
        }
        else
        {
            echo "Emails Do not match";
            exit();
        }
    }
?>