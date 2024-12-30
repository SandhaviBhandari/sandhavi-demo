<?php
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'flex_partition');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = $conn->real_escape_string($_POST['title']);
                $description = $conn->real_escape_string($_POST['description']);

                $sql = "INSERT INTO posts (post_title, post_description) VALUES ('$title', '$description')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Post added successfully!</p>";
                } else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
            }

            // Fetch posts from the database
            $result = $conn->query("SELECT * FROM posts ORDER BY id DESC");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post'>";
                    echo "<h3>" . htmlspecialchars($row['post_title']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['post_description']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No posts yet.</p>";
            }

            $conn->close();
            ?>