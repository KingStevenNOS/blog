<?php
session_start();
include_once("db.php");

if(isset($_POST['post'])) {
    $title = strip_tags($_POST['title']);
    $content = strip_tags($_POST['content']);

    $title = mysqli_real_escape_string($db,$title);
    $content = mysqli_real_escape_string($db,$content);

    $date = date('l jS \of F Y h:i:s A');

    $sql = "INSERT into posts (title, content, date) VALUES ('$title','$content','$date')";

    if($title == "" || $content=="") {
      echo "Please Complete your Post!";
      return;
    }
    mysqli_query($db,$sql);
    
    header("Location: index.php");

}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>title</title>
  </head>
  <body>
      <form action="posts.php" method="POST" enctype="multipart/form-data">
          <fieldset>
              <LEGEND>Post your Content</LEGEND>
            <input placeholder="title" name="title" type="text" autofocus size="48"><br/><br/>
            <textarea placeholder="content" name="content" rows="20" cols="50"></textarea><br/>
            <input name="post" type="submit" value="Post">
          </fieldset>
      </form>
  
  </body>
</html> 