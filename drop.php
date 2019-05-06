<?php

	session_start();
	$username = $_SESSION['username'];
	$db = mysqli_connect("localhost", "user", "user123", "foss_lab");
	$uid = mysqli_fetch_array(mysqli_query($db, "SELECT uid FROM users WHERE username='$username'"))['uid'];
	mysqli_query($db, "DELETE from tasks WHERE uid='$uid' AND done=1");
	header('location: tasks.php');

?>