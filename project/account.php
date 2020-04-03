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
            <div class="creditCardForm">
                <div class="heading">
                    <h1>Confirm Purchase</h1>
                </div>
                <div class="payment">
                    <div class="form-group" id="card-number-field">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber">
                    </div>
                    <form method="POST" >
                        <div class="form-group CVV">
                            <label for="CVV">CVV</label>
                            <input type="text" class="form-control" id="CVV">
                        </div>
                    
                        <div class="form-group" id="expiration-date">
                            <label>Expiration Date</label>
                            <select>
                                <option value="01">January</option>
                                <option value="02">February </option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <select>
                                <option value="16"> 2016</option>
                                <option value="17"> 2017</option>
                                <option value="18"> 2018</option>
                                <option value="19"> 2019</option>
                                <option value="20"> 2020</option>
                                <option value="21"> 2021</option>
                            </select>
                        </div>
                    <div class="form-group" id="pay-now">
                        <button type="submit" class="button" id="confirm-purchase">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    //verify it
    if(isset($_POST['cardNumber']) && isset($_POST['CVV']) && isset($_POST['expiration-date']) 
    && !empty($_POST['cardNumber']) && !empty($_POST['CVV']) && !empty($_POST['expiration-date']))
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
                WHERE id = $id");
                
            $stmt->execute();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
                		
    }
    elseif (empty($_POST['CVV'])
    {
        echo "<script type='text/javascript'>alert('Invalid CVV');</script>";
    }
    elseif (empty($_POST['cardNumber'])
    {
        echo "<script type='text/javascript'>alert('Invalid cardNumber');</script>";
    }
    elseif (empty($_POST['expiration-date'])
    {
        echo "<script type='text/javascript'>alert('Invalid expiration-date');</script>";
    }
    else
    {
        echo "wow"
    }           
?>