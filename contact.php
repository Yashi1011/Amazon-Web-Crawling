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

$email = $username = $email = "";

if(isset($_POST['messagebtn'])){
    include("connection.php");
    $email = $_POST["email"];
    $message = $_POST["message"];
    $username = $_SESSION["username"];
    $sql = "INSERT INTO $table_messages (email, message, username)
    VALUES ('$email', '$message', '$username')";
    if (mysqli_query($con, $sql)) {
        echo '<div class="alert-box"><div class="alert alert-success" role="alert"> Message sent successfully </div></div>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

?>

<body>
    <div class="center">
        <div class="page-header">
            <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h2>
            <p>
                <a href="user.php" class="btn btn-info">Search Amazon</a>
                <a href="logout.php" class="btn btn-danger">Log Out</a>
            </p>
        </div>
    </div>

    <div class="contact">
        <div class="form-1">            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="center">
                    <h1>CONTACT US</h1>
                    <h4>We'd love to hear from you!</h4>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <textarea type="textarea" name="message" class="form-control" placeholder="Message" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="messagebtn" value="Send" class="btn btn-block create-account">
                </div>
            </form>
        </div>
    </div>
</body>
</html>