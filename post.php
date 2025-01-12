


    $sql= "INSERT INTO posts (post_title, post_description, user_id) VALUES ('$title', '$description', $_SESSION[user_id])";
    $result= mysqli_query($conn, $sql);

   ?> <div class="nav">
        <div class="logedin">
            Logged In as: <?php echo$username; ?>
        </div>
    </div>
    <?php
    
    
    if ($result){

    echo"<script>
    alert('posted');
    </script>";
    header("Location:posts.php");

    }else{
    echo"<script>
        alert('error');
        </script>";
        header("Location:dashboard.php");
    }



}