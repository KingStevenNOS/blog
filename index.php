<?php
    include_once("db.php");
    include_once("search.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Blog</title>
</head>

<body>
    <div>
        <?php
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 4;
        $offset = ($pageno - 1) * $no_of_records_per_page;

        $total_pages_sql = "SELECT COUNT(*) FROM posts";
        $pages_data = mysqli_query($db,$total_pages_sql);
        $rows_fetched = mysqli_fetch_array($pages_data)[0];
        $total_pages = ceil($rows_fetched / $no_of_records_per_page);
        ?>
        <ul class="pagination">
            <li><a href="?pageno=1">First</a></li>
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
            </li>
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
            </li>
            <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
        </ul>
    </div>
        
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
            echo "<a href='admin.php'>Admin</a> | <a href='posts.php'>Post</a> | <a href='logout.php'>Logout</a>";
        }
        if (!isset($_SESSION['username'])){
            echo "<a href='login.php'>Login</a><br/>";
            echo "<a href='register.php'>Register</a><br/>";

        }
        if (isset($_SESSION['username']) && !isset($_SESSION['admin'])){
            echo "<a href='logout.php'>Logout</a>";
        }
        ?>
            
    </div>
    

</body>
</html>