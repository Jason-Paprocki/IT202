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
    ini_set('display_errors',1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    //the user needs to be logged in to continue
    //this checks for that
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

    //now that the user is logged in; we can continue
    else
    {
?>
        <section class="text-center">
            <form method="POST">
                <div class = "text-center">
                $5 a month, how many months?
                </div>
                <input type="months" id="months" name="months" placeholder="months" />
                <br>
                <input type="submit" value="Buy" />
            </form>
        </section>
<?php
        $id = $_SESSION['id'];
        if(isset($_POST['months']))
        {
            if(is_numeric($_POST['months']) && $_POST['months'] > 0)
            {
                require("config.php");
                $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
                try
                {
                    $db = new PDO($connection_string, $dbuser, $dbpass);

                    date_default_timezone_set("America/New_York");
                    $currentDate = date("Y-m-d");
                    $months = $_POST['months'];


                    //checks if there is already a date
                    $stmt = $db->prepare(
                        "SELECT endDate 
                        from `AppUsers` 
                        where id = :id LIMIT 1");
                    $params = array(":id"=> $id);
                    $stmt->execute($params);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $pastDate = $result['endDate'];
                    
                    if ($pastDate >= $currentDate)
                    {
                        //if there is already date that is greater than today in the persons account than it will take the 
                        //date in the database and add time to that
                        $endDate = date("Y-m-d", strtotime($pastDate . ' + ' . $months . ' months'));
                        $stmt = $db->prepare(
                        "UPDATE `AppUsers`
                        SET endDate = :endDate
                        WHERE id = :id");
                        $params = array(
                                ":id" => $id,
                                ":endDate" => $endDate);
                        $stmt->execute($params);
                        
                    }
                    else 
                    {
                        //this is for when the user has run out of time and has to bet time set from today
                        $endDate = (string) (date("Y-m-d", strtotime($currentDate . ' + ' . $months . ' months')));
                         $stmt = $db->prepare(
                            "UPDATE `AppUsers`
                            SET endDate = :endDate
                            WHERE id = :id");
                        $stmt->bindValue(':endDate', $endDate); 
                        $stmt->bindValue(':id', $id);
                        $stmt->execute();
                    }
                    
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                    exit();
                }
            }
            else
            {
                echo "<script type='text/javascript'>alert('Invalid months');</script>";
            }
        }
        
    }
    

?>