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
$logged_in_user_id = $_SESSION['user_id'];

// Database connection
$con = mysqli_connect("localhost", "root", "", "futsal", "3306");

// Check if delete_id is set in the URL
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
}else{
    $delete_id=null;
}
   

    // Check if the logged-in user owns the post
    // $query = "SELECT * FROM posts WHERE post_id = '$delete_id' AND username = '$username'";
    $query_check = "select user_id from posts where post_id = '$delete_id'";


    $result = mysqli_query($con, $query_check);
    $post_owner_user_id = $result->fetch_assoc()['user_id'];
    

    if (mysqli_num_rows($result) > 0) {
        if($post_owner_user_id == $logged_in_user_id){
               // User owns the post, delete it
        $delete_query = "DELETE FROM posts WHERE post_id = '$delete_id'";
        mysqli_query($con, $delete_query);
        } else { 
            echo "<script>alert('You are not authorized to delete this post.');</script>";
        }
     
    }


// Fetch all posts from the database
$query = "SELECT * FROM posts";
$query_run = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flex Partition</title>
    <style>
html{
    scroll-behavior: smooth;
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .nav {
            background-color: green;
            color: white;
            height: 40px;
            width: 200px;
            margin-left: auto;
        }

        body {
            font-family: Arial, sans-serif;
            height: 50vh;
            background-color: rgb(109, 128, 0);
        }

        .container {
            display: flex;
            padding: 20px;
            gap: 30px;
        }

        .right {
    flex: 1;
    background: rgb(82, 135, 58);
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 8px;
    max-height: 600px; /* Set your desired height */
    overflow-y: auto; /* Enable vertical scrolling */
}

        .left, .right {
            flex: 1;
            background: rgb(82, 135, 58);
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        .left h2, .right h2 {
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, textarea {
            padding: 10px;
            border: 1px solid black;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            padding: 10px;
            background: green;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 80px;
        }

        .container_posts {
            background-color: antiquewhite;
            color: black;
            border: 2px solid cornsilk;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            max-width: 500px;
            max-height: fit-content;
            word-wrap: break-word;
            word-break: break-word;
            overflow: hidden;
            white-space: normal;
        }

        .container_posts .title {
            background-color: cadetblue;
            color: black;
            height: 100px;
        }

        .container_posts .description {
            height: 95px;
        }

        .delete {
            height: 18px;
            width: 60px;
            background-color: red;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 5px;
        }

        .delete a {
            color: white;
            text-decoration: none;
        }

        .edit{
            height: 18px;
            width: 60px;
            background-color: red;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logedin">Logged In as: <?php echo $username; ?></div>
    </div>
    <div class="container">
        <div class="left">
            <h2>Add Post</h2>
            <form method="POST" action="post.php">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required />
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="5" cols="30"></textarea>
                <button type="submit">Add Post</button>
            </form>
        </div>
        <div class="right">
            <h2>My Posts</h2>
            <?php
            if (mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $row) {
                    ?>
                    <div class="container_posts">
                        <div class="title">
                            <?= ($row['post_title']); ?> <br>

                        </div>
                        <div class="description">
                            <?= ($row['post_description']); ?>
                        </div>
                    
                            <div class="delete">
                                <a href="?delete_id=<?= $row['post_id']; ?>">Delete</a>
                            </div>
                           <div class="edit">
    <a href="edit.php?edit_id=<?= $row['post_id']; ?>">Edit</a>
</div>

                    </div>
                    <?php
                }
            } else {
                echo "No Post Found";
            }
            ?>
        </div>
    </div>
</body>
</html>
