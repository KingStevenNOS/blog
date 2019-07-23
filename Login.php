<?php
	session_start();

	if(isset($_POST['login'])){
		include_once("db.php");

		$username = strip_tags($_POST['username']);
		$password = strip_tags($_POST['password']);

		$username = stripslashes($username);
		$password = stripslashes($password);

		$username = mysqli_real_escape_string($db, $username);
		$password = mysqli_real_escape_string($db, $password);

		$password = md5($password);

		$sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
		$query = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($query);
		$id = $row['id'];
		$db_password = $row['password'];
		$admin = $row['admin'];

		if($password == $db_password) {
			$_SESSION['username'] = $username;
			$_SESSION['id'] = $id;
			if($admin ==1){
				$_SESSION['admin'] = 1;
			}
			
			header("Location: index.php");
		}
		else{
			echo "Incorrect username or Password!";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1 style="font-family: Tahoma">Login</h1>
	<form action="login.php" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>Login</legend>
			<input placeholder="Username" type="text" name="username" autofocus>
			<input placeholder="Password" type="password" name="password">
			<input type="submit" name="login" value="Login">
		</fieldset>
	</form>
	<a href="index.php">Home</a>


</body>
</html>