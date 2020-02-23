<html>
	<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<title>Jason Paprocki</title>
        <script>
			function verifyPasswords(form){
				if(form.password.value.length == 0 || form.confirm.value.length == 0){
					alert("You must enter both a password and confirmation password");
					return false;
				}
				if(form.password.value != form.confirm.value){
					alert("Uhh you made a typo");
					return false;
				}
				return true;
			}
		</script>
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
        <h1>Register</h1>
        </header>
    </article>

    <section class = "text-center">
        <form name="regform" id="myForm" method="POST" onsubmit="return verifyPasswords(this)">
            <input type="email" id="email" name="email" placeholder="Email"/>
            <br>
            <input type="password" id="password" name="password" placeholder="Password"/>
            <br>
            <input type="password" id="confirm" name="confirm" placeholder="Confirm Password"/>
            <br>
            <input type="submit" value="Register"/>
        </form>
    </section>
</html>

<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(	   isset($_POST['email']) 
	&& isset($_POST['password'])
	&& isset($_POST['confirm'])
    )
    
    {
	$pass = $_POST['password'];
    $conf = $_POST['confirm'];
    $timeLeft = 0;
    if($pass == $conf)
    {
		echo "All good, 'registering user'";
	}
	else{
		echo "What's wrong with you? Learn to type";
		exit();
	}
	//let's hash it
    $pass = password_hash($pass, PASSWORD_BCRYPT);

	//it's hashed
	require("config.php");
	$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try
    {
		$db = new PDO($connection_string, $dbuser, $dbpass);
		$stmt = $db->prepare("INSERT INTO `AppUsers`
                        (email, password, timeLeft) VALUES
                        (:email, :password, :timeLeft)");
		$email = $_POST['email'];
        $params = array(":email"=> $email, 
                    ":password"=> $pass,
                    ":timeLeft"=>$timeLeft);
        $stmt->execute($params);
        
        
        
        session_start();
        $_SESSION["email"] = ":email";
        $_SESSION["redirect"] = "register";


        header("Location: account.php");
	}
	catch(Exception $e){
		echo $e->getMessage();
		exit();
	}
}
?>