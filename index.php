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
			$dbpass = mysqli_query($db,"SELECT password FROM users WHERE username = '$username' ");
			$p = mysqli_fetch_array($dbpass)["password"];
			// echo $p;
			if(empty($p)){
				$error = 4;
			}
			else if($p == $password){
				// $error = "Success";
				header('location: tasks.php');
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
				if ($error == 4) { 
					echo "<p style='color: red;'>Username does not exist!</p>";
				}
				?>
				<input name="username" type="text">
				<input name="password" type="password">
				<button name="submit" type="submit">Login</button>
			</form>
			
		</div>
	</body>
</html>