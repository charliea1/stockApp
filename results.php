<?php
    require "config.php";
    //use session to store stock if it is bought
    $_SESSION['purchased'] = $_GET['stock'];
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
		<div id="results_display" class="container">
            <h2 style="color:mediumseagreen; margin-top:40px;">"<?php echo $_GET['stock']?>" Information</h2>
            <hr style="border:1px solid grey">

            <form action="portfolio.php" method="GET">
                <input style="background-color:mediumseagreen; border:1px solid black; color:black; border-radius:3px;"type="submit" value="Buy shares">
                <input style="width:30px;background-color:mediumseagreen; border:1px solid black; color:black; border-radius:3px;" type="text" id="num_shares" name="num_shares">
            </form>
            <hr style="border:1px solid grey">
            <div id="name"></div>
            <hr style="border:1px solid grey">
            <div id="price"></div>
            <div id="trend"></div>
            <hr style="border:1px solid grey">
            <div id="source"></div>
            <h4></h4>
            <div id="news"></div>
            <a id="more"></a>
            
        </div>
			
		</div>
		<script src="main.js"></script>
        <script>
        let name = window.location.search;
        name = name.slice(7);
        ajax("https://finnhub.io/api/v1/stock/profile2?symbol=" + name +  "&token=bs1srb7rh5r9p5hv81q0", 0);
        ajax("https://finnhub.io/api/v1/quote?symbol=" + name + "&token=bs1srb7rh5r9p5hv81q0", 1);
        ajax("https://finnhub.io/api/v1/company-news?symbol=" + name + "&from=2020-06-20" + "&to=2020-07-07" + "&token=bs1srb7rh5r9p5hv81q0", 2);
        </script>
        
    </body>
</html>

