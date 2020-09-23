<?php
require "config.php"
/*if(!isset($_SESSION)) 
{ 
    session_start(); }*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">

        <title>Global</title>
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
		<div style="margin-top:40px;" class="container">
			<h1 style="color:mediumseagreen;">Global Rankings</h1>
            <?php
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	            if($mysqli->connect_errno) {
		            echo $mysqli->connect_error;
		            exit();
                }
                $sql_ranking = "SELECT username, cash FROM users ORDER BY cash desc;";
                $results_ranking = $mysqli->query($sql_ranking);
	            if(!$results_ranking) {
		            echo $mysqli->error;
		            exit();
                }
                ?>
                <h4>
                <hr style="border:2px solid grey;">
                <table style="width:50%;">
                <tr style="color:mediumseagreen;">
                    <th>Rank</th>
                    <th>User</th>
                    <th>Value<th>
                </tr>
                    <?php $rank = 1;
                    while($row = $results_ranking->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $rank; $rank=$rank+1;?></td>
                            <td><?php echo $row['username']?></td>
                            <td><?php echo $row['cash']?></td>
                        </tr>
                    <?php endwhile ?>
                </table>
                <!-- while($row = $results_ranking->fetch_assoc()){ -->
                    <!-- echo $row['username']; -->
                <!-- } -->
            
		</div>
			
		</div>
		<script src="main.js"></script>
    </body>
</html>
