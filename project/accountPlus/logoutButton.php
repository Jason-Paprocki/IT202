<html>
        <section class = "text-center">
            <form method="post">
            <input type="submit" name="LogoutButton"
                class="button" value="Logout" /> 
            </form>
        </section>
</html>



<?php
//checks if the button has been pressed and then calls then logs the user out
    if(array_key_exists('LogoutButton', $_POST)) 
    { 
        session_unset();
        session_destroy();
        echo " <section class = 'text-center'> <h2> You have been logged out </h2> </section> ";
        //echo var_export($_SESSION, true);
        //get session cookie and delete/clear it for this session
        if (ini_get("session.use_cookies"))
        { 
            $params = session_get_cookie_params(); 
            //clones then destroys since it makes it's lifetime
            //negative (in the past)
            setcookie(session_name(), '', time() - 42000, 
                $params["path"], $params["domain"], 
                $params["secure"], $params["httponly"] 
            ); 
        } 
    }
?>