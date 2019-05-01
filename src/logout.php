<?php

if (session_status() == PHP_SESSION_NONE)
	session_start();

if (isset($_SESSION['username']))
	unset($_SESSION['username']);

$redirectto = "category.php";

if (!empty($_GET['previouspage']))
	$redirectto = $_GET['previouspage'];
else if (!empty($_POST['previouspage']))
	$redirectto = $_POST['previouspage'];

header("location: $redirectto");

?>
