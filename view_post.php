<?php
    session_start();
    include_once("db.php");

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
    
    if(mysqli_num_rows($res)>0){
        while($row = mysqli_fetch_assoc($res)){
            $id =$row['id'];
            $title =$row['title'];
            $content =$row['content'];
            $date =$row['date'];
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
                $admin = "<div><a href='del_post.php?pid=$id'>Delete</a> | <a href='edit_posts.php?pid=$id'>Edit</a>";
            }
            else{
                $admin="";
            }
            $output = $bbcode->Parse($content);
            
            $posts.= "<div><h2>$title</h2><h4>$date</h4><p>$output</p><p>$admin</p> <a href='index.php'>Return</a></div>";
        }
        echo $posts;
    }
    else {
        echo "There are no Blog Posts to display! <br/> <a href='index.php'>Return</a>";
    }
    ?>

</body>

</html>
