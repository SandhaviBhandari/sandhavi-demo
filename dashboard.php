<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: index.html");
    exit;
}

// Retrieve the username from the session
$username = $_SESSION['username'];

?>
<html>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="dashboard.css"> 
<body>

    <div class="nav">
        <div class="logedin">
            Logged In as: <?php echo$username; ?>
        </div>
    </div>
    <div class="container">
        <div class="left">
            <h2>Add Post</h2>
            <form method="POST" action="">
                <label for="title">Title:</label>
        <input type="title" id="Title" name="Title" required>
        <label for ="description">Description:</label>
       <textarea id="description" name "decription" rows="20" cols="30"></textarea>
       


                <button type="submit">Add Post</button>
            </form>
        </div>
        <div class="right">
            <h2>My Posts</h2>
           
        </div>
    </div>
</body>

</html>


<?php


?>
