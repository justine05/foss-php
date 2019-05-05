<?php
	$db = mysqli_connect("localhost", "user", "user123", "foss_lab");
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
		<table>
	<thead>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th>Description</th>
			<th>Priority</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		$username = $_GET['user'];
		$uid = mysqli_fetch_array(mysqli_query($db, "SELECT uid FROM users WHERE username='$username'"))['uid'];
		// $uid_row = $uid_table);
		// $uid = $uid_row['uid'];
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($db, "SELECT t.title, t.descr, t.priority, t.done FROM tasks t, users u WHERE t.uid='$uid' ORDER BY priority");
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
	</body>
</html>