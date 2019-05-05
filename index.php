<?php
	$db = mysqli_connect("localhost","user","user123","foss_lab");
	$error = "";
	if (isset($_POST['submit'])) {
		if (empty($_POST['username'])) {
			$error = "Username canot be empty";
		}
		else if (empty($_POST['password'])) {
			$error = "Password canot be empty";
		}
		else {
			$username = $_POST["username"];
			$password = $_POST["password"];
			$dbpass = mysqli_query($db,"SELECT password FROM users WHERE username = '$username' ");
			$p = mysqli_fetch_array($dbpass)["password"];
			// echo $p;
			if($p === ""){
				$error = "Username doesnot exist";
			}
			else if($p === $password){
				$error = "Success";
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
				<input name="username" type="text">
				<input name="password" type="password">
				<button type="submit">Login</button>
				<?php 
					if (isset($error)) { ?>
						<p><?php echo $errors; ?></p>
				<?php
					}
				 ?>
			</form>
			
		</div>
	</body>
</html>