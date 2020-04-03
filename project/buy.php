<html>
	<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<title>Jason Paprocki</title>
	</head>

    <header>
        <div class="nav justify-content-md-center">
            <li class="nav-item">
			    <a class="nav-link" href="register.php">Register</a>
		    </li>
            <li class="nav-item">
			    <a class="nav-link" href="login.php">Login</a>
		    </li>
            <li class="nav-item">
			    <a class="nav-link" href="home.php">Home</a>
		    </li>
            <li class="nav-item">
			    <a class="nav-link" href="account.php">Account</a>
		    </li>
            <li class="nav-item">
			    <a class="nav-link" href="download.php">Download</a>
		    </li>
            <li class="nav-item">
			    <a class="nav-link" href="buy.php">Buy</a>
		    </li>
        </div>
    </header>


    <section id = "space area">
        <!--- Created space to center things-->
        <br>
    </section>

    <article>
        <header class = "text-center">
        <h1>Buy</h1>
        </header>
    </article>
</html>
<?php

    session_start();
    if (!isset($_SESSION["id"]))
    {
?>
        <div class = "text-center">
           Please Login to Coninue
        </div>
        <section class = "text-center">
            <form method="post">
            <input type="submit" name="LoginButton"
                class="button" value="Login" /> 
            </form>
        </section>

        <div class = "text-center">
           You can also register here
        </div>
        <section class = "text-center">
            <form method="post">
            <input type="submit" name="Register"
                class="button" value="Register" /> 
            </form>
        </section>
<?php
        //login button
        if(array_key_exists('LoginButton', $_POST)) 
        { 
            header("Location: login.php");
        }
        //register button
        if(array_key_exists('Register', $_POST)) 
        { 
            header("Location: register.php");
        }
    }

?>