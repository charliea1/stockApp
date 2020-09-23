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

        <title>Create an account</title>
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
                <form action="register_confirm.php" method="POST" style="margin-top:40px;">
                    <?php
                        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
                        echo "Already logged in as " . $_SESSION["username"];
                    }
                    ?>
                    <h2 style="color:mediumseagreen;">Create an account</h2>
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
                        <button style="margin-left:auto; color:black; background-color:mediumseagreen; border-color:black;" type="submit" class="btn btn-primary">Register</button>
					    <a  style="background-color:grey; border-color:black; color:black;" href="home.php" role="button" class="btn btn-light">Cancel</a>
                    </div>
                </form>
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