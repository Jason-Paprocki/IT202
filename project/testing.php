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
        </div>
    </header>


    <section id = "space area">
        <!--- Created space to center things-->
        <br>
    </section>

    <article>
        <header class = "text-center">
        <h1>account</h1>
        </header>
    </article>

    
</html>
<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();    
    if (isset($_SESSION["email"]))
    {
?>
        <section class = "text-center">
            <form method="post">
            <input type="submit" name="LogoutButton"
                class="button" value="Logout" /> 
            </form>
        </section>
<?php
    }

    if ($_SESSION["redirect"] == "login")
    {
        echo "Thank you for logging in";
    }
    
    if ($_SESSION["redirect"] == "register") 
    {
        echo "Thank you for registering";
    }

    if(array_key_exists('LogoutButton', $_POST)) 
    { 
        logout(); 
    }

    function logout() 
    { 
        session_unset();
        session_destroy();
        echo "You have been logged out";
        echo var_export($_SESSION, true);
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
    if (isset($_SESSION["email"]))
    {
?>
<section class = "text-center">
        <form name="regform" id="myForm" method="POST" onsubmit="return verifyPasswords(this)">
            <input type="cardNumber" id="cardNumber" name="cardNumber" placeholder="cardNumber"/>
            <br>
            <input type="CVV" id="CVV" name="CVV" placeholder="CVV"/>
            <br>
            <input type="password" id="expiration-date" name="expiration-date" placeholder="expiration-date"/>
            <br>
            <input type="submit" value="Submit"/>
        </form>
    </section>
     
<?php
    }
    //verify it  
    if(isset($_POST['cardNumber']) && isset($_POST['CVV']) && isset($_POST['expiration-date']))
    {
        $id = $_SESSION['id'];
        $cardNumber = $_POST['cardNumber'];
        $CVV = $_POST['CVV'];
        $expDate = $_POST['expiration-date'];
        
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try 
        {

		    $db = new PDO($connection_string, $dbuser, $dbpass);
		    $stmt = $db->prepare(
                "UPDATE `CreditCardInfo`
                SET cardNum = :cardNumber,
                expDate = :expDate,
                CVV = :CVV,
                WHERE id = :id");
            $params = array(
                        ":id" => $id,   
                        ":cardNumber" => $cardNumber,
                        ":expDate" => $expDate,
                        ":CVV" => $CVV);
            $stmt->execute($params);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }

    }
?>