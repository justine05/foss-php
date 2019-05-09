<?php
	
	session_start();
	$db = mysqli_connect("localhost", "user", "user123", "foss_lab");
	$error = 1;
	if (isset($_POST['submit'])) {
		if (empty($_POST['username'])) {
			$error = 2;
		}
		else if (empty($_POST['password'])) {
			$error = 3;
		}
		else {
			$username = $_POST["username"];
			$password = $_POST["password"];
			$dbpass = mysqli_query($db,"SELECT password FROM users WHERE username = '$username' ");
			$p = mysqli_fetch_array($dbpass)["password"];
			if(empty($p)){
				$error = -1;
			}
			else if (password_verify($password, $p)){
				$error = 0;
				$_SESSION['username'] = $username;
				header('location: tasks.php');
			}
			else {
				$error = -1;
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" type="text/css" href="assets/style.css">
		<link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
		<title>Login | To-Do Manager</title>
	</head>
	<body>
		<header>
			<h2 style="font-style: 'Hervetica';">The To-Do App</h2>
		</header>
		<div class="form-container">
			<form action="index.php" method="POST" class="form">
				<?php 
				if ($error == 2) { 
					echo "<p class='error-msg'>Username cannot be empty!</p>";
				}
				if ($error == 3) { 
					echo "<p class='error-msg'>Password cannot be empty!</p>";
				} 
				if ($error == -1) {
					echo "<p class='error-msg'>Username and password do not match!</p>";
				}
				?>
				<label for="username">Username: </label>
				<input id="username" name="username" type="text">
				<br>
				<label for="password">Password: </label>
				<input id="password" name="password" type="password"><br><br>
				<button name="submit" type="submit">Login</button>
				<br>
				<p>New here? Click <a href="register.php">here</a> to register.</p>
			</form>

		</div>
	</body>
</html>