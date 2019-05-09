<?php
	$db = mysqli_connect("localhost", "user", "user123", "foss_lab");
	$error = 1;
	if (isset($_POST['submit'])) {
		if (empty($_POST['username'])) {
			$error = 2;
		}
		else if (empty($_POST['password']) || empty($_POST['reenter'])) {
			$error = 3;
		}
		else {
			$username = $_POST["username"];
			$password = $_POST["password"];
			$reenter = $_POST["reenter"];			
			$dbpass = mysqli_query($db,"SELECT username FROM users WHERE username = '$username' ");
			$uname = mysqli_fetch_array($dbpass)["username"];
			// echo $p;
			if(!empty($uname)){
				$error = -1;
			}
			else if($password != $reenter){
				$error = -2;
			}
			else {
				$hash = password_hash($password, PASSWORD_DEFAULT);
				mysqli_query($db,"INSERT INTO users(username, password) VALUES ('$username','$hash')");
				header('location: index.php');
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
		<title>Register | To-Do Manager</title>
	</head>
	<body>
		<header>
		<h2 style="font-style: 'Hervetica';">The To-Do App</h2>
		</header>
		<div class="form-container register-form-container">
			<form action="register.php" method="POST" class="register-form">
				<?php 
				if ($error == 2) { 
					echo "<p class='error-msg'>Username cannot be empty!</p>";
				}
				if ($error == 3) { 
					echo "<p class='error-msg'>Password fields cannot be empty!</p>";
				} 
				if ($error == -1) {
					echo "<p class='error-msg'>Username already exists. Try another username.</p>";
				}
				if ($error == -2) {
					echo "<p class='error-msg'>Password fields don't match.</p>";
				}
				?>
				<label for="username">Enter username:</label>
				<input name="username" id="username" type="text"><br>
				<label for="password">Enter password:</label>
				<input name="password" type="password" id="password"><br>
				<label for="reenter">Re-enter password:</label>
				<input name="reenter" type="password" id="reenter">
				<br><br>
				<button name="submit" type="submit">Register</button>
				<br>
				<p>Already have an account? Click <a href="index.php">here</a> to login.</p>
			</form>
			
		</div>
	</body>
</html>