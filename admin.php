<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["type"]=='user'){
    header("location: user.php");
    exit;
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/simple-sidebar.css"/>
    <link rel="stylesheet" href="css/formstyle.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .alert-box{
            top:100px;
            width: 35%;
            position: relative;
            margin: auto;
        }
        body {
            background: #7F7FD5;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

            font-family: "Comic Sans MS", "Comic Sans", cursive;
        }
    </style>
</head>
<body>

    <div id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <form method="post">
                    <li>
                        <button name="search">Search Amazon Data</button>
                    </li>
                    <li>
                        <button name="adduser">Add User</button>
                    </li>
                    <li>
                        <button name="deleteuser">Delete User</button>
                    </li>
                    <li>
                        <button name="showuser">Show User</button>
                    </li>
                    <li>
                        <button name="showmessages">Show Messages</button>
                    </li>
                    <li>
                        <button name="download">Download User Data</button>
                    </li>
                    <li>
                        <button name="logout">Log Out</button>
                    </li>
                </form>
            </ul>
        </div>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Menu</a>
                        <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h2>
                        <br><br>
                        
                    
    

<?php
include('connection.php');

// Define variables and initialize with empty values
$username = $password = $cnfpassword = $phone = $dob = $type = $websiteErr = $message = "";

// Funtion to trim and process the input fields.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['search'])){
    header("location: user.php");
}

if(isset($_POST['logout'])){
    header("location: logout.php");
}

if(isset($_POST['add'])){
    // Storing the form inputs to variables.
    $username = test_input($_POST["username"]);
    $pass = test_input($_POST["password"]);
    $password = encrypt(test_input($_POST["password"]));
    $cnfpassword = test_input($_POST["cnfpassword"]);
    $dob = test_input($_POST["birth-date"]);
    $phone = test_input($_POST["phone-number"]);
    $type = test_input($_POST["type"]);
    
    // Checking if there are records with that username.
    $sql = "SELECT username FROM $table_users WHERE username='$username'";
    $out = mysqli_query($con, $sql);
    // If there is atleast one record then username is taken.
    if(mysqli_num_rows($out) > 0){
        echo '<div class="alert-box"><div class="alert alert-danger" role="alert"> User with that username '.$username.' exists! </div></div>';
    }
    // Else the data is inserted in database.
    else{
        if($pass == $cnfpassword){
            $sql = "INSERT INTO $table_users (username, password, phone, birth_date, type) VALUES ('$username', '$password', '$phone', '$dob', '$type')";
            if(mysqli_query($con, $sql) === TRUE){
                echo '<div class="alert-box"><div class="alert alert-success" role="alert"> '.$username.' added successfully!! </div></div>';
            }else {
                echo '<div class="alert-box"><div class="alert alert-danger" role="alert"> Error connecting to database! </div></div>';
            }
        }
        else{
            echo '<div class="alert-box"><div class="alert alert-danger" role="alert"> Password and Confirm password did not match. </div></div>';
        }
        
    }
}

if(isset($_POST['delete'])){
    // Storing the form inputs to variables.
    $username = trim($_POST["username"]);
    $phone = trim($_POST["phone-number"]);
    $type = trim($_POST["type"]);

    // Checking if there are records with that email.
    $sql = "SELECT username,type,phone FROM $table_users WHERE username='$username'";
    $out = mysqli_query($con, $sql);

    // If there is atleast one record then email is taken.
    if(mysqli_num_rows($out) == 0){
        echo '<div class="alert-box"><div class="alert alert-warning" role="alert"> No person with that username '.$username.' exists </div></div>';
    }
    // Else the data is deleted in database.
    else{
        $row = mysqli_fetch_array($out, MYSQLI_ASSOC);
        if($type ==  $row['type']){
            if($phone == $row['phone']){
                $sql = "DELETE FROM $table_users WHERE username = '$username'";
                if(mysqli_query($con, $sql) === TRUE) {
                    echo '<div class="alert-box"><div class="alert alert-info" role="alert"> ' . $username . ' deleted </div></div>';
                }else {
                    echo "Error: " . $con->error;
                }
            }
            else{
                echo '<div class="alert-box"><div class="alert alert-danger" role="alert"> Category ' . $phone . ' didnt match the registered data </div></div>';
            }
        }
        else{
            echo '<div class="alert-box"><div class="alert alert-danger" role="alert"> Category ' . $type . ' didnt match the registered data </div></div>';
        }
        
    }
}

if(isset($_POST['adduser'])) { 
    echo "<br><br>
    <div class='form-1'>
    
    <form method='post'>
        <h1 class='center'>Add User</h1>
        <div class='form-group'>
            <input type='text' class='form-control item' name='username' id='username' placeholder='Username' required>
        </div>
        <div class='form-group'>
            <input type='password' class='form-control item' name='password' id='password' placeholder='Password' required>
        </div>
        <div class='form-group'>
            <input type='text' class='form-control item' name='cnfpassword' id='cnfpassword' placeholder='Confirm Password' required>
        </div>
        <div class='form-group'>
            <input type='text' class='form-control item' name='phone-number' id='phone-number' placeholder='Phone Number' required>
        </div>
        <div class='form-group'>
            <input type='text' class='form-control item' name='birth-date' id='birth-date' placeholder='Birth Date YYYY-MM-DD' required>
        </div>
        <div class='form-group'>
            <lable for='type'> Type:</lable>&emsp;&emsp;&emsp;&emsp;
            <label class='radio-inline'><input type='radio' name='type' value='user' checked required>  User  </label>&emsp;&emsp;&emsp;&emsp;
            <label class='radio-inline'><input type='radio' name='type' value='admin'>  Admin  </label>
        </div>
        <div class='form-group'>
            <input type='submit' name='add' value='Add User' class='btn btn-block create-account'>
        </div>
    </form></div>";
}

if(isset($_POST['deleteuser'])) { 
    echo "<br><br>
    <div class='form-1'>
    
    <form method='post'>
        <h1 class='center'>Delete User</h1>         
        <div class='form-group'>
            <input type='text' class='form-control item' name='username' id='username' placeholder='Username' required>
        </div>
        <div class='form-group'>
            <input type='text' class='form-control item' name='phone-number' id='phone-number' placeholder='Phone Number' required>
        </div>
        <div class='form-group'>
            <lable for='type'> Type:</lable>&emsp;&emsp;&emsp;&emsp;
            <label class='radio-inline'><input type='radio' name='type' value='user' checked required>  User  </label>&emsp;&emsp;&emsp;&emsp;
            <label class='radio-inline'><input type='radio' name='type' value='admin'>  Admin  </label>
        </div>
        <div class='form-group'>
            <input type='submit' name='delete' value='Delete User' class='btn btn-block create-account'>
        </div>
    </form></div>";
}

if(isset($_POST['showuser'])) {
    $sql = "SELECT username, phone, type, birth_date FROM $table_users";
    $out = mysqli_query($con, $sql);
    if (mysqli_num_rows($out) > 0) {
        echo "<br><div><div class='container'><table class='table'><tr><td><b>Username</b></td><td><b>Phone</b></td><td><b>Date of Birth</b></td><td><b>Category</b></td></tr>";
        // output data of each row
        while($row = $out->fetch_assoc()) {
            echo "<tr><td>" . $row["username"]. "</td><td>" .$row["phone"]. "</td><td>" . $row["birth_date"]. "</td><td>". $row["type"]. "</td></tr>";
        }
        echo "</table></div></div>";
    } else {
        echo "0 results";
    }
}

if(isset($_POST['showmessages'])){
    $sql = "SELECT username, message, email FROM $table_messages";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo "<br><div><div class='container'><table class='table'><tr><td><b>Username</b></td><td><b>Message</b></td><td><b>Email</b></td></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["username"]. "</td><td>" .$row["message"]. "</td><td>" . $row["email"]. "</td></tr>";
        }
        echo "</table></div></div>";
    } else {
        echo "0 results";
    }
}

if(isset($_POST['download'])) {
    $sql = "SELECT * FROM $table_users";
    $result = $con->query($sql);
    $myfile = fopen("C:\\xampp\\htdocs\\task1\\file.json", "w") or die("Unable to open file!");
    fwrite($myfile, "[\n");
    foreach($result as $row) {
        $x['username'] = $row['username'];
        $x['phone'] = $row['phone'];
        $x['birth_date'] = $row['birth_date'];
        $x['type'] = $row['type'];
        $x['reg_at'] = $row['reg_at'];
        fwrite($myfile, json_encode($x));
        fwrite($myfile, ",\n");
    }
    fwrite($myfile, "]");
    fclose($myfile);

    $file = ("C:\\xampp\\htdocs\\task1\\file.json");

    $filetype=filetype($file);

    $filename="file.json";

    header ("Content-Type: ".$filetype);

    header ("Content-Length: ".filesize($file));

    header ("Content-Disposition: attachment; filename=".$filename);

    readfile($file);
    echo '<div class="alert-box"><div class="alert alert-success" role="alert"> Data downloaded successfully! </div></div>';
}
?>
                        <p class='help-block error'><?php echo $websiteErr; ?></p>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        function logOut() {
            // logout.php file removes the stored cookie.
            window.location.href = "logout.php";
        }

        function searchAmazon() {
            // logout.php file removes the stored cookie.
            window.location.href = "user.php";
        }

        $(document).ready(function () {
            // writing the format of DOB and phine number
            $('#birth-date').mask('0000-00-00');
            $('#phone-number').mask('0000-000-000');
        })

        $("#menu-toggle").click(function(e){
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        })

    </script>
</body>
</html>
