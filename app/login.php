<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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


<section id="space area">
    <!--- Created space to center things-->
    <br>
</section>

<article>
    <header class="text-center">
        <h1>Login</h1>
    </header>
</article>

<section class="text-center">
    <form method="POST">
        <input type="email" id="email" name="email" placeholder="Email" />
        <br>
        <input type="password" id="password" name="password" placeholder="Password" />
        <br>
        <input type="submit" value="Login" />
    </form>
</section>

</html>

<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
	$pass = $_POST['password'];
	$email = $_POST['email'];

	require("config.php");
	$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	try {
		$db = new PDO($connection_string, $dbuser, $dbpass);
		$stmt = $db->prepare("SELECT email, password from `AppUsers` where email = :email LIMIT 1");
		
        $params = array(":email"=> $email);
        $stmt->execute($params);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
        if($result)
        {
			$userpassword = $result['password'];
			
            if(password_verify($pass, $userpassword))
            {
                $_SESSION["email"] = ":email";
                $_SESSION["redirect"] = "login";
                header("Location: account.php");
                
			}
			else{
				echo "Failed to login, invalid password";
			}
		}
		else{
			echo "Invalid email";
		}
	}
	catch(Exception $e){
		echo $e->getMessage();
		exit();
	}
}
?>