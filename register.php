<?php
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
			$reenter = $_POST["reenter"];			
			$dbpass = mysqli_query($db,"SELECT username FROM users WHERE username = '$username' ");
			$uname = mysqli_fetch_array($dbpass)["username"];
			// echo $p;
			if(!empty($p)){
				$error = -1;
			}
			else if($password != $reenter){
				$error = -2;
			}
			else {
				mysqli_query($db,"INSERT INTO `users`(`username`, `password`) VALUES ('$username','$password')");
				header('location: login.php');
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
		<title>Login | To-Do Manager</title>
	</head>
	<body>
		<h2 style="font-style: 'Hervetica';">ToDo App</h2>
		<div class="form-container">
			<form action="index.php" method="POST" class="form">
				<?php 
				if ($error == 2) { 
					echo "<p style='color: red;'>Username cannot be empty!</p>";
				}
				if ($error == 3) { 
					echo "<p style='color: red;'>Password cannot be empty!</p>";
				} 
				if ($error == -1) {
					echo "<p style='color: red;'>Username already exists. Try another username.</p>";
				}
				if ($error == -2) {
					echo "<p style='color: red;'>Password fields don't match.</p>";
				}
				?>
				<label for="username">Enter username:</label>
				<input name="username" id="username" type="text">
				<label for="password">Enter password:</label>
				<input name="password" type="password" id="password">
				<label for="reenter">Re-enter your password:</label>
				<input name="reenter" type="password" id="reenter">
				<button name="submit" type="submit">Register</button>
			</form>
			
		</div>
	</body>
</html>