<?php
    session_start();

    include_once("db.php");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Blog</title>
</head>

<body>
    <div>
        <?php
        require_once("nbbc/nbbc.php");
        $bbcode=new BBCode;
        if (isset($_GET["search"]) && strlen($_GET["search"]) >= 0) {
            $search = $_GET["search"];
            $sql="SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY id DESC LIMIT 4";
            $res = mysqli_query($db, $sql) or die(mysqli_error($db));
            $posts = "";
            if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){
                    $id =$row['id'];
                    $title =$row['title'];
                    $content =$row['content'];
                    $date =$row['date'];
                    $substr_value = substr($row['content'], 0, 200);
                    $output = $bbcode->Parse($substr_value);
                    $posts.= "<div><h2><a href='view_post.php?pid=$id'>$title</a></h2><h3>$date</h3><p>$output ...</p><a href='view_post.php?pid=$id'>read more</a> <hr/></div>";
                }
                echo $posts;
            }else{
                echo "There are no results<br/>";
            }
        }else{
            $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 4";
            $res = mysqli_query($db, $sql) or die(mysqli_error($db));
            $posts = "";
        }
        ?>
    </div>
    <div>
        <form action="search.php" method="GET">
            <input placeholder="Type Search Here" type="text" name="search" />
            <input type="submit" value="Search" />
        </form>
        <?php
        if (isset($_SESSION['admin']) && $_SESSION['admin']==1){
            echo "<a href='admin.php'>Admin</a> | <a href='posts.php'>Post</a> | <a href='logout.php'>Logout</a> | ";
            echo "<a href ='index.php'>return</a>";
        }
        if (!isset($_SESSION['username'])){
            echo "<a href='login.php'>Login</a><br/>";
            echo "<a href='register.php'>Register</a><br/><br/>";
            echo "<a href ='index.php'>return</a>";


        }
        if (isset($_SESSION['username']) && !isset($_SESSION['admin'])){
            echo "<a href='logout.php'>Logout</a> | ";
            echo "<a href ='index.php'>return</a>";
        }
        ?>
    </div>

</body>
</html>