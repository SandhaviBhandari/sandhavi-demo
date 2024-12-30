<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$port = '3306';
$dbname = "futsal";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $password = $_POST['password'];


$sql = "SELECT * FROM user WHERE Name='$name' AND Password='$password'";
$result = mysqli_query($conn, $sql);

if (($result->num_rows) > 0) {

    $_SESSION['username'] = $name; // setting the session variable it is a global variable
    $user_details = $result->fetch_assoc();
    $SESSION['user_id'] = $user_details["id"];
    

    // Success: Redirect to a dashboard or welcome page
    echo "<script>
            alert('Login successful!');
          </script>";
       header("Location:dashboard.php");      
} else {
    // Failure: Show error message
    echo "<script>
            alert('Invalid name or password. Please try again.');
            window.location.href = 'index.html'; 
          </script>";
}
}

?>