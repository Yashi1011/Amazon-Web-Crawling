<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel = "stylesheet" href = "css/style.css"/>
    <link rel = "stylesheet" href = "css/formstyle.css"/>
</head>

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<body>
    <div class="center">
        <div class="page-header">
            <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h2>
            <p>
                <a href="contact.php" class="btn btn-info">Contact Us</a>
                <a href="logout.php" class="btn btn-danger">Log Out</a>
            </p>
        </div>
    </div>
    <div class="form-1">        
        <form action="user.php" method="get">
            <div class="form-group">
                <input type="text" class="form-control item" name="search" id="search" placeholder="Search here....">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Search" class="btn btn-block create-account">
            </div>
        </form>
    </div>
        

    <div class="products">

    <?php
        // Include files
        include("amazon.php");

        // Initializing arrays for data, title, image and price
        $amazon_data = Array();
        $amazon_title = Array();
        $amazon_img = Array();
        $amazon_price = Array();

        // if search is not fetched through get method, kill rest of the page
        if(!isset($_GET['search'])){
            die();
        }

        // Called funtions that fetch HTML
        $amazon_data = amazon($_GET['search']);

        // Storing data in different arrays
        $j=0;
        foreach($amazon_data[0] as $x){
            array_push($amazon_title, $x);
            $j++;
            if($j>20){
                break;
            }
        }

        $j=0;
        foreach($amazon_data[1] as $x){
            array_push($amazon_img, $x);
            $j++;
            if($j>20){
                break;
            }
        }

        $j=0;
        foreach($amazon_data[2] as $x){
            array_push($amazon_price, $x);
            $j++;
            if($j>20){
                break;
            }
        }

        // displaying data
        $j = 0;
        echo "<div class='container'>";
        
        foreach($amazon_title as $x){
            echo "<div class='columns'>";
            echo "<div class='cards'>";
            echo "<img class='card-img center' src='".@$amazon_img[$j]."' style = 'width: 200px; height: 270px;'>";
            echo "<br/><div class='center'><p class='card-text'>".@$x."</p></div>";
            echo "<div class='price text-success center'><h5 class='mt-4'>".@$amazon_price[$j]."</h5></div>";
            echo "</div></div>";
            if(($j+1)%3==0){
                echo "</div><div class='container'>";
            }
            $j++;
        }
        echo "</div>";

    ?>
    </div>
</body>
</html>