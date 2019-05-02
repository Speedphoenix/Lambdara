<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

function setPrevPage()
{
	if (!empty($_GET['previouspage']))
	{
		$_SESSION['previouspage'] = $_GET['previouspage'];
		unset($_GET['previouspage']);
	}
	else if (!empty($_POST['previouspage']))
	{
		$_SESSION['previouspage'] = $_POST['previouspage'];
		unset($_POST['previouspage']);
	}
}

function getPrevPage($defaultpage)
{
	setPrevPage();
	if (!empty($_SESSION['previouspage']))
		return $_SESSION['previouspage'];
	else
		return $defaultpage;
}


?>
