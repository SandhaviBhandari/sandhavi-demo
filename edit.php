<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit;
}

// Retrieve the username and user ID from the session
$username = $_SESSION['username'];
$logged_in_user_id = $_SESSION['user_id'];

// Database connection
$con = mysqli_connect("localhost", "root", "", "futsal", "3306");

// Check if edit_id is set in the URL
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    // Fetch the post data for the given post ID
    $query_check = "SELECT * FROM posts WHERE post_id = '$edit_id'";
    $result = mysqli_query($con, $query_check);
    $post = mysqli_fetch_assoc($result);

    if (!$post || $post['user_id'] != $logged_in_user_id) {
        echo "<script>alert('You are not authorized to edit this post.'); window.location.href = 'dashboard.php';</script>";
        exit;
    }
}

// Update the post when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_title = ($con, $_POST['title']);
    $new_description = ($con, $_POST['description']);

    $update_query = "UPDATE posts SET post_title = '$new_title', post_description = '$new_description' WHERE post_id = '$edit_id'";
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Post updated successfully.'); window.location.href = 'posts.php';</script>";
    } else {
        echo "<script>alert('Failed to update the post.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(109, 128, 0);
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-container {
            background-color: rgb(82, 135, 58);
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        .edit-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: black;
            
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-size: 14px;
        }

        input, textarea {
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            outline: none;
            color: black;
        }

        textarea {
            resize: none;
        }

        button {
            background-color: green;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            align-self: center;
            width: 100px;
        }

        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Post</h2>
        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['post_title']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($post['post_description']); ?></textarea>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
