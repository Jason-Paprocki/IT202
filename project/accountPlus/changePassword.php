<html>
    <section class = "text-center">
        Change Password
        <form name="regform" id="myForm" method="POST" onsubmit="return verifyPasswords(this)">
            <input type="password" id="password" name="password" placeholder="New Password"/>
            <br>
            <input type="password" id="confirm" name="confirm" placeholder="Confirm New Password"/>
            <br>
            <input type="submit" value="Change Password"/>
        </form>
    </section>
</html>


<?php
    if(
        isset($_POST['password'])
	&& isset($_POST['confirm'])
    )
    {
        $pass = $_POST['password'];
        $conf = $_POST['confirm'];

        if($pass == $conf)
        {
            $id = $_SESSION['id'];

            //hash the new password
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            require "db_connection.php";
            try
            {
                $stmt = $db->prepare(
                    "UPDATE `AppUsers`
                    SET password = :pass
                    WHERE id = :id");
                $params = array(
                            ":id" => $id,
                            ":pass" => $pass);
                $stmt->execute($params);
                echo " <section class = 'text-center'> <h2> Password has been changed </h2> </section> ";
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                exit();
            }
        }
        else
        {
            echo " <section class = 'text-center'> <h2> Passwords Do not match </h2> </section> ";
            exit();
        }
    }
?>