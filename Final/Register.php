<html>
	<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<title>Register</title>
	</head>

    <header>
        <ul class= "nav navbar-dark bg-dark rounded-lg" style = "margin-left: 0px!important;">
            <li class="nav-item">
                <a class="nav-link" href="app/login.php">Class++ (Pilot)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://github.com/MattToegel/IT202">IT202 GitHub</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://github.com/MattToegel/IT114">IT114 GitHub</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://github.com/MattToegel/IT490">IT490 GitHub</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">IS601 GitHub TBD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">IT340 GitHub TBD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#officehours">Office Hours</a>
            </li>
        </ul>
    </header>


    <section id = "space area">
        <!--- Created space to center things-->
        <br>
    </section>

    <article>
        <header class = "text-center">
        <h1 class = "display-3">Proxy</h1>
        </header>
    </article>

    <section class = "text-center">
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email"/>
            <br>
            <label for="pass">Password: </label>
            <input type="password" id="pass" name="password" placeholder="Enter password"/>
            <br>
            <label for="conf">Confirm Password: </label>
            <input type="password" id="conf" name="confirm" placeholder="Confirm password"/>
            <br>
            <input type="submit" value="Register"/>
        </form>
    </section>
</html>