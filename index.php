<?php
    include_once("db.php");
    include_once("search.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
</head>

<body>
    <div>
        <?php
        require_once("nbbc/nbbc.php");
        $bbcode=new BBCode;

        $sql="SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
        $res = mysqli_query($db, $sql) or die("Error in Connection".mysqli_error($db));
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
        }
        else {
            echo "There are no Blog Posts to display!<br/>";
        }?>
    </div>
    <div>
        <?php
        if (isset($_SESSION['admin']) && $_SESSION['admin']==1){
            echo "<a href='admin.php' class='button big'>Admin</a> | <a href='posts.php' class='button big'>Post</a> | <a href='logout.php' class='button big'>Logout</a>";
        }
        if (!isset($_SESSION['username'])){
            echo "<a href='login.php' class='button big'>Login</a><br/>";
            echo "<a href='register.php' class='button big'>Register</a><br/>";

        }
        if (isset($_SESSION['username']) && !isset($_SESSION['admin'])){
            echo "<a href='logout.php' class='button big'>Logout</a>";
        }
        ?>
        <div class="pagination">
            <a href="?pageno=1">First</a> ||
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a> ||
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a> ||
            <a href="?pageno=<?php echo $total_pages; ?>">Last</a>
        </div>
            
    </div>
    

</body>
</html>