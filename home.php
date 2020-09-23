<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">

        <title>Home</title>
    </head>
    <body>
        <div class="container">
            <div id="logo">
				<div id="buffer1"></div>
				~stonks~
            </div>
            <div id="nav-border">
                <?php if(isset($_SESSION["logged_in"]) && $_SESSION['logged_in']): ?>
                    Logged in as <?php echo $_SESSION["username"]?> || <a style="color:mediumseagreen" href="logout.php">Log out</a>
                <?php else:?>
                    Not signed in
                <?php endif ?>
            </div>
            <div id="nav">
                
                <a href="home.php"><button type="button" class="btn">Home</button></a>
                <a href="portfolio.php"><button type="button" class="btn">Portfolio</button></a>
                <a href="global.php"><button type="button" class="btn">Global</button></a>

            </div>
		</div>
		<div class="clear"></div>
		<div class="container">
			<div>
            <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]):?>
            <h1 style="margin-top:20px; color:mediumseagreen;">Create an account to see portfolio highlights</h1>
            <a style="color:mediumseagreen;"href="sign_in.php">Sign in</a> or <a style="color:mediumseagreen;" href="register.php">create an account</a> to create a custom portfolio
            <?php endif?>
        </div>
		</div>
			
		</div>
		<script src="main.js"></script>
    </body>
</html>
