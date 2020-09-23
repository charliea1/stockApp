<?php
//session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
    $error = "Already logged in as " . $_SESSION["username"];
}
require 'config.php';

// If no user is logged in, do the usual things. Otherwise, redirect user out of this page.
if( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {

	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		if ( empty($_POST['username']) || empty($_POST['password']) ) {

			$error = "Please enter username and password.";

		}
		else {
			// User did enter username/password but need to check if the username/pw combination is correct
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			// Hash whatever user typed in for password, then compare this to the hashed password in the DB
			$passwordInput = hash("sha256", $_POST["password"]);

			$sql = "SELECT * FROM users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";

			
			$results = $mysqli->query($sql);

			if(!$results) {
				echo $mysqli->error;
				exit();
			}

			// If we get 1 result back, means username/pw combination is correct.
			if($results->num_rows > 0) {
				// Set sesssion variables to remember this user
				$_SESSION["username"] = $_POST["username"];
				$_SESSION["logged_in"] = 1;

				// Success! Redirect user to the home page
				header("Location: home.php");
			
			}
			else {
				$error = "Invalid username or password.";
			}
		} 
	}
}
else {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">

        <title>Sign in</title>
    </head>
    <body>
        <div class="container">
            <div id="logo">
				<div id="buffer1"></div>
				~stonks~
            </div>
            <div id="nav-border"></div>
            <div id="nav">
                
                <a href="home.php"><button type="button" class="btn">Home</button></a>
                <a href="portfolio.php"><button type="button" class="btn">Portfolio</button></a>
                <a href="global.php"><button type="button" class="btn">Global</button></a>

            </div>
		</div>
		<div class="clear"></div>
		<div class="container">
			<div>
                <form action="sign_in.php" method="POST" style="margin-top:40px;">
                    <h2 style="color:mediumseagreen;">Sign in</h2>
                    <div class="form-group row">
				        <label for="username" class="col-sm-2 col-form-label text-sm-right">Username:</label>
				        <div class="col-sm-8">
					        <input style="background-color:mediumseagreen; border:1px solid black; color:black;" type="text" class="form-control" id="username" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
				        <label for="password" class="col-sm-2 col-form-label text-sm-right">Password:</label>
				        <div class="col-sm-8">
					        <input style="background-color:mediumseagreen; border:1px solid black; color:black;" type="text" class="form-control" id="password" name="password">
                        </div>
                    </div>
                        <button style="margin-left:auto; color:black; background-color:mediumseagreen; border-color:black;" type="submit" class="btn btn-primary">Enter</button>
					    <a  style="background-color:grey; border-color:black; color:black;" href="home.php" role="button" class="btn btn-light">Cancel</a>
                    </div>
                </form>
                <?php
        if(isset($error)){
            echo $error;
        }
        ?> 
			</div>
		</div>
			
		</div>
        <script>
		// validate input w JS
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#username-id').value.trim().length == 0 ) {
				document.querySelector('#username-id').classList.add('is-invalid');
			} else {
				document.querySelector('#username-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#password-id').value.trim().length == 0 ) {
				document.querySelector('#password-id').classList.add('is-invalid');
			} else {
				document.querySelector('#password-id').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
        </script>
    </body>
</html>