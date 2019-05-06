<?php
	session_start();
	$db = mysqli_connect("localhost", "user", "user123", "foss_lab");
	$username = $_SESSION['username'];
	if($username == NULL){
		header('location: index.php');
	}
	$error = 0;
	if (isset($_POST['submit'])){
		if(empty($_POST['title'])){
			$error = -1;
		}
		else {
			$error = 1;
		}
	}
	if (isset($_GET['del_task'])) {
		$tid = $_GET['del_task'];
		mysqli_query($db, "UPDATE tasks SET done=1 WHERE tid=".$tid);
		header('location: tasks.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" type="text/css" href="assets/style.css">
		<link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
		<title>Tasks | To-Do Manager</title>
	</head>
	<body>
		<header>
		<a href="logout.php" class="logout">Logout</a>

		<h1><?php echo "Welcome, ".$username; ?></h1>
		</header>
		<div class="task-list">

			<form class='add-task-form' action='tasks.php' method='POST'>
				<input placeholder="Task Title" type="text" name="title"><br>
				<input placeholder="Optional Task Description" type="text" name="descr"><br>
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
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tasks = mysqli_query($db, "SELECT t.tid, t.title, t.descr, t.priority, t.done FROM tasks t, users u WHERE t.uid='$uid' AND u.uid=t.uid ORDER BY priority DESC, done");
				// echo "SELECT t.title, t.descr, t.priority, t.done FROM tasks t, users u WHERE t.uid='$uid' AND t.uid=u.uid ORDER BY priority";
				$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr>
					<?php
					$title = $row['title'];
					$descr = $row['descr'];
					$priority = $row['priority'];
					if ($row['done'] == 0) {
					echo "<td>$i</td>";
					echo "<td>$title</td>";
					echo "<td>$descr</td>";
					echo "<td>$priority</td>";
					}
					else {
					echo "<td class='task-done'>$i</td>";
					echo "<td class='task-done'>$title</td>";
					echo "<td class='task-done'>$descr</td>";
					echo "<td class='task-done'>$priority</td>";
					}
					?>
					<?php if ($row['done'] == 0) { ?>
						 <td><a href="tasks.php?del_task=<?php echo $row['tid'] ?>">Mark as Done</a></td>
					<?php } ?>
					<?php if ($row['done'] != 0) { ?>
						 <td></td>
					<?php } ?>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>

		<div class="drop-button-parent">
			<a href="drop.php"><button class="drop-button">Delete Done Tasks</button></a>
		</div>

		</div>
		<body>
</html>