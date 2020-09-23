<?php
require "config.php";
//session_start();

if ( !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out the two required fields.";
}

else{
	// Store this user into the database!
	// connect to db
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	// Check if username is taken
	$sql_registered = "SELECT * FROM users 
	WHERE username = '" . $_POST["username"] . "';";

	$results_registered = $mysqli->query($sql_registered);
	if(!$results_registered) {
		echo $mysqli->error;
		exit();
	}

	if($results_registered->num_rows > 0) {
		$error = "Username already taken.";
	}
	else {
		$password = hash("sha256", $_POST["password"]);

		// To add a new user, INSERT INTO the newly created users tbale

		$sql = "INSERT INTO users(username, password) VALUES('" . $_POST["username"] . "','" . $password . "');";

		$results = $mysqli->query($sql);
		if(!$results) {
			echo $mysqli->error;
			exit();
		}
	}

    $mysqli->close();

    $_SESSION["username"] = $_POST["username"];
    $_SESSION["logged_in"] = 1;
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

        <title>Register Confirmation</title>
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
            <div class="row mt-4">
			    <div style="margin-top:40px;"class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div><?php echo $_POST['username']; ?> was successfully registered.</div>
				<?php endif; ?>
                </div> <!-- .col -->
            </div>
        </div>
    </body>
</html>