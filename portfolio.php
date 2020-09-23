<?php
/*if(!isset($_SESSION)) 
{ 
    session_start(); 
}*/
//session_start();
require "config.php";


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">

        <title>Portfolio</title>
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
            <?php
                //if no session/user logged in, continue'nt
                if(!isset($_SESSION['username']) || !$_SESSION['logged_in']){
                    echo "<h2 style='margin-top:40px; color:grey;'><a style='color:mediumseagreen;' href='sign_in.php'>Sign in</a> to search for stocks and create a portfolio.</h2>";
                }
                else{

                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	            if($mysqli->connect_errno) {
		            echo $mysqli->connect_error;
		            exit();
                }
                //first get user info from DB
                $sql_user = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "';";
                $results_user = $mysqli->query($sql_user);
                if(!$results_user){
                    echo $mysqli->error;
                    exit();
                }
                $row = $results_user->fetch_assoc();
                $id = $row['id'];

                //first check if user has no existing portfolio
	            $sql_port = "SELECT * FROM port_stocks 
	            WHERE user_id = '" . $id . "';";

	            $results_port = $mysqli->query($sql_port);
	            if(!$results_port) {
		            echo $mysqli->error;
		            exit();
                }
                if ($results_port->num_rows == 0){
                    echo "<h2 style='margin-top:40px; color:mediumseagreen;'>Search for stocks to add to your portfolio!</h2>";
                }
                else{
                    echo "<h2 style='margin-top:40px; color:mediumseagreen'>Your Portfolio</h2>";
                    while($row=$results_port->fetch_assoc()){
                        echo "<hr style='border:1px solid grey'>";
                        $sql_stock = "SELECT name FROM stocks WHERE id = " . $row["stock_id"] . ";";

                        $results_stock = $mysqli->query($sql_stock);
	                    if(!$results_stock) {
		                    echo $mysqli->error;
		                    exit();
                        }
                        $row2 = $results_stock->fetch_assoc();
                        echo $row2["name"] . ": " . $row["number"] . " shares";
                        echo '<form action="portfolio.php" method="GET">
                        <input style="display:none" name="sold" value="'.$row2["name"].'">
                        <input style="background-color:red; border:1px solid black; color:white; border-radius:3px;" type="submit" value="Sell shares">
                        <input style="width:30px;background-color:red; border:1px solid black; color:white; border-radius:3px;" type="text" id="num_sold" name="num_sold" value="1">
                        </form>';
                    }
                }

                //sell stock

                if(isset($_GET["num_sold"]) && isset($_GET["sold"])){
                    $sql_stock = "SELECT id FROM stocks WHERE name = '" . $_GET['sold'] . "';";
                    $results_stock = $mysqli->query($sql_stock);
                    if(!$results_stock){
                        echo $mysqli->error;
		                exit();
                    }
                    $stock = $results_stock->fetch_assoc();
                    $stock = $stock["id"];

                    ////////// ensure no rows of this stock already
                    $sql_check = "SELECT * FROM port_stocks WHERE stock_id = " . $stock;
                    $results_check = $mysqli->query($sql_check);
                    if(!$results_check){
                        echo $mysqli->error;
		                exit();
                    }
                    if($results_check->num_rows > 0){
                        $total = 0;
                        while($row=$results_check->fetch_assoc()){
                            $total = $row["number"];
                        }
                        $total = $total - $_GET["num_sold"];
                        if($total > 0 ){
                            $sql_buy = "UPDATE port_stocks SET number=" . $total . " WHERE stock_id=" . $stock . " AND user_id=" . $id . ";";
                        }
                        else{
                            $sql_buy = "DELETE FROM port_stocks WHERE user_id=" . $id . " AND stock_id=" . $stock . ";";
                        }
                    }
                    /////////http://localhost:8888/final/portfolio.php?sold=TSLA&num_shares=1
                    $results_buy = $mysqli->query($sql_buy);
                    if(!$results_buy){
                        echo $mysqli->error;
		                exit();
                    }
                }
                //////////////////////

                //add purchased stock to DB
                if(isset($_GET["num_shares"]) && isset($_SESSION["purchased"])){
                    $sql_stock = "SELECT id FROM stocks WHERE name = '" . $_SESSION['purchased'] . "';";
                    $results_stock = $mysqli->query($sql_stock);
                    if(!$results_stock){
                        echo $mysqli->error;
		                exit();
                    }
                    $stock = $results_stock->fetch_assoc();
                    $stock = $stock["id"];

                    ////////// ensure no rows of this stock already
                    $sql_check = "SELECT * FROM port_stocks WHERE stock_id = " . $stock;
                    $results_check = $mysqli->query($sql_check);
                    if(!$results_check){
                        echo $mysqli->error;
		                exit();
                    }
                    if($results_check->num_rows > 0){
                        $total = 0;
                        while($row=$results_check->fetch_assoc()){
                            $total = $total + $row["number"];
                        }
                        $total = $total + $_GET["num_shares"];
                        $sql_buy = "UPDATE port_stocks SET number=" . $total . " WHERE stock_id=" . $stock . " AND user_id=" . $id . ";";
                    }
                    else{
                        $sql_buy = "INSERT INTO port_stocks(user_id,stock_id,number) VALUES (" . $id . "," . $stock . "," . $_GET['num_shares'] . ");";
                    }

                    /////////
                    $results_buy = $mysqli->query($sql_buy);
                    if(!$results_buy){
                        echo $mysqli->error;
		                exit();
                    }
                }


                
                }

            ?>
            <hr style="margin-top:60px;border:1px solid grey;">
            <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
            <form style="margin-top:30px;"action="portfolio.php" method="GET">
                <label for="search">Search stock abbreviation:</label>
                <input style="background-color:mediumseagreen; border:1px solid black; color:black; border-radius:3px;" type="text" id="search" name="search">
                <input style="background-color:mediumseagreen; border:1px solid black; color:black; border-radius:3px;"type="submit" value="Search">
            </form>
            <?php endif ?>
            <?php
            if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']){
                exit();
            }
            if(isset($_GET['search']) && !empty($_GET['search'])){
                $term = $_GET['search'];
                $sql_search = "SELECT name FROM stocks WHERE name LIKE '%" . $_GET['search'] . "%';";
                $results_search = $mysqli->query($sql_search);
                if(!$results_search){
                    echo $mysqli->error;
                    exit();
                }
                //echo "<hr style='border:1px solid grey'>";

                while($row = $results_search->fetch_assoc()){
                    echo "<a style='color:mediumseagreen;' href='results.php?stock=" . $row['name'] . "'>" . $row['name'] . "</a>";
                    echo "<hr style='border:1px solid grey'>";

                }
            }
        
            ?>
		</div>
			
		</div>
		<script src="main.js"></script>
    </body>
</html>
