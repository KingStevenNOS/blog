<?php
	if(isset($_SESSION['id'])){
		header("Location: index.php");
	}
	if(isset($_POST['register'])){
		include_once("db.php");

		$username = strip_tags($_POST['username']);
		$password = strip_tags($_POST['password']);
		$password_confirm = strip_tags($_POST['password_confirm']);
		$email = strip_tags($_POST['email']);

		$username = stripslashes($username);
		$password = stripslashes($password);
		$password_confirm = stripslashes($password_confirm);
		$email = stripslashes($email);

		$username = mysqli_real_escape_string($db, $username);
		$password = mysqli_real_escape_string($db, $password);
		$password_confirm = mysqli_real_escape_string($db, $password_confirm);
		$email = mysqli_real_escape_string($db, $email);

		$password = md5($password);
		$password_confirm = md5($password_confirm);

		$sql_store = "INSERT INTO users (username, password, email) VALUES ('$username','$password','$email')";
		$sql_fetch_username = "SELECT username FROM users WHERE username = '$username'";
		$sql_fetch_email = "SELECT email FROM users WHERE email = '$email'";
		
		$query_username = mysqli_query($db, $sql_fetch_username);
		$query_email = mysqli_query($db, $sql_fetch_email);

		if(mysqli_num_rows($query_username)){
			echo "There is already a user with that name!";
			
		}
		if($username ==""){
			echo "please enter a Username";
			
		}
		if($password == ""){
			echo "Please enter a password";
			
		}
		if ($password_confirm == ""){
			echo "Please confirm your password";
		}
		if ($password != $password_confirm) {
			echo "The passwords do not match";
			
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)|| $email==""){
			echo "please enter a valid E-Mail Address";
			
		}
		if(mysqli_num_rows($query_email)){
			echo "That email is already registered and in Use! <br />";

		}
		

		mysqli_query($db, $sql_store);

		header("Location: index.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<form action="register.php" method="post" enctype="multipart/form-data">
		<input placeholder="Username" type="text" name="username">
		<input placeholder="password" type="password" name="password">
		<input placeholder="Confirm Password" type="password" name="password_confirm">
		<input placeholder="E-Mail Address" type="email" name="email">
		<input name="register" type="submit" value="register">
	</form>

	<a href="index.php">Home</a>
</body>
</html>