<?php

include_once "genericFuncs.php";

if (session_status() == PHP_SESSION_NONE)
	session_start();

if (isset($_SESSION['username']))
	unset($_SESSION['username']);

header("location: " . getPrevPage("category.php"));

?>
