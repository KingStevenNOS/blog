<?php
    session_start();
    include_once("db.php");

if(!isset($_SESSION['admin'])&& $_SESSION['admin']!=1){
    header("Location: login.php");
    return;
}

?>
<!doctype html>
<html>

<head>
    <title>Blog</title>
</head>

<body>
    <?php
    require_once("nbbc/nbbc.php");
    $bbcode=new BBCode;
    $sql="SELECT * FROM posts ORDER BY id DESC";
    $res = mysqli_query($db,$sql) or die(mysqli_error());
    $posts = "";
    
    if(mysqli_num_rows($res) > 0){
        while($row = mysqli_fetch_assoc($res)){
            $id =$row['id'];
            $title =$row['title'];
            $date =$row['date'];
            $content = $row['content'];
            $admin = "<div><a href='del_post.php?pid=$id'>Delete</a>;<a href='edit_posts.php?pid=$id'>Edit</a></div>";
            
            $output = $bbcode->Parse($content);
            
            $posts.= "<div><h2><a href='view_post.php?pid=$id' target='_blank'>$title</a></h2><h3>$date</h3>$admin</div>";
        }
        echo $posts;
    }
    else {
        echo "There are no Blog Posts to display!";
    }
            
    ?>
    <a href="posts.php">Post</a>
</body>

</html>
