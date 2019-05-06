<?php
	session_start();
	$_SESSION['username'] = NULL;
	header('location: index.php');
?>