<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "futsal_booking";
$port = '3306';

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn) {
    echo "Connection successful!";
} else {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Insert query
    $sql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "Account created successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>
