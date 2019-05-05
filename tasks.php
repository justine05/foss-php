<!-- INSERT INTO `tasks` (`tid`, `title`, `descr`, `uid`, `priority`, `done`) VALUES (NULL, 'LAMP Login Form', NULL, '2', '3', '0'); -->

<?php
	session_start();
	$db = mysqli_connect("localhost", "user", "user123", "foss_lab");
	$username = $_SESSION['username'];
	$error = 0;
	if (isset($_POST['submit'])){
		if(empty($_POST['title'])){
			$error = -1;
		}
		else {
			$error = 1;
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
		<title>Tasks | To-Do Manager</title>
	</head>
	<body>
		<h1><?php echo "Welcome, ".$username; ?></h1>
		<div class="task-list">

			<form class='add-task-form' action='tasks.php' method='POST'>
				<input placeholder="Task Title" type="text" name="title">
				<input placeholder="Optional Task Description" type="text" name="descr">
				<input placeholder="Priority (0-5)" type="text" name="priority">
				<button type="submit" name="submit">Add Task</button>
			</form>
			<?php 	
				$uid = mysqli_fetch_array(mysqli_query($db, "SELECT uid FROM users WHERE username='$username'"))['uid'];
				if($error == -1) {
					echo "<p class='error-msg'>Task title cannot be empty!</p>";
				}
				else if ($error == 1) {
					if (empty($_POST['priority'])) {
						$priority = 3;
					}
					else {
						$priority = $_POST['priority'];
					}
					$title = $_POST['title'];
					$descr = $_POST['descr'];
					$sql = "INSERT INTO tasks(title, descr, uid, priority) VALUES ( '$title', '$descr', $uid, $priority);";
					mysqli_query($db, $sql);
					// $error = 0;
					// echo $sql;
				}
			 ?>

		<table>
			<thead>
				<tr>
					<th>Sl. No.</th>
					<th>Tasks</th>
					<th>Description</th>
					<th>Priority</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tasks = mysqli_query($db, "SELECT t.title, t.descr, t.priority, t.done FROM tasks t, users u WHERE t.uid='$uid' AND u.uid=t.uid ORDER BY priority");
				// echo "SELECT t.title, t.descr, t.priority, t.done FROM tasks t, users u WHERE t.uid='$uid' AND t.uid=u.uid ORDER BY priority";
				$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr>
					<td> <?php echo $i; ?> </td>
					<td class="task"> <?php echo $row['title']; ?> </td>
					<td><?php echo $row['descr']; ?></td>
					<td><?php echo $row['priority']; ?></td>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>

		</div>
	</body>
</html>