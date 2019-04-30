<?php

include_once "config.php";
include_once "dbFuncs.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (session_status() == PHP_SESSION_NONE)
	session_start();

foreach ($_POST as $key => $elem)
{
	if ($key !== 'password' && $key !== 'confirm-password')
		$_POST[$key] = htmlspecialchars($elem);
}

function passIsSecure($password)
{
	return (is_string($password) && (strlen($password) >= 2));
}

$errormsg = "";

function loginusr($conn)
{
	if (empty($_POST['username']) || empty($_POST['password']))
	{
		return ERREMPTYFIELD;
	}
	
	$result = $conn->query("SELECT * FROM users WHERE username='" . $_POST['username'] . "';");

	if ($result->num_rows !== 1)
		$result = $conn->query("SELECT * FROM users WHERE email='" . $_POST['email'] . "';");

	if ($result->num_rows !== 1)
		return ERRUSRNOTFOUND;	
	else if (password_verify($_POST['password'], $result->fetch_assoc()['password_hash']))
	{
		$_SESSION['username'] = $_POST['username'];
		return "";
	}
	else
		return ERRUSRNOTFOUND;
	return "";
}

function registerusr($conn)
{
	if (empty($_POST['fullname']) || empty($_POST['username']) || empty($_POST['email'])
		|| empty($_POST['password']) || empty($_POST['confirm-password']))
		return ERREMPTYFIELD;

	if (!passIsSecure($_POST['password']))
		return ERRUNSAFEPASS;
	
	if ($_POST['password'] !== $_POST['confirm-password'])
		return ERRPASSNOMATCH;

	$result = $conn->query("SELECT * FROM users WHERE username='" . $_POST['username'] . "';");
	if ($result->num_rows !== 0)
		return ERRNAMETAKEN;

	$result = $conn->query("SELECT * FROM users WHERE email='" . $_POST['email'] . "';");
	if ($result->num_rows !== 0)
		return ERREMAILTAKEN;
	
	$query = "INSERT INTO users (username, email, password_hash, permissions)
				VALUES ('" . $_POST['username'] . "', '" . $_POST['email'] . "'," .
				" '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', '0');";

	$result = $conn->query($query);
	if ($result !== true)
		return ERRSQLINSI;
	addUserCentral($_POST['username'], $_POST['fullname'], $_POST['email']);
	return "";
}

function loginon()
{
	global $errormsg;

	if (isset($_SESSION['username']))
		return; //already logged
	if (empty($_POST['formtype']))
		return;
	if (!(isset($_POST['formtype']) && 
			($_POST['formtype'] === 'register' && isset($_POST['fullname'])
			&& isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])
			&& isset($_POST['confirm-password']))
		||
			($_POST['formtype'] === 'login' && isset($_POST['username'])
			&& isset($_POST['password']))))
	{
		return;
	}

	$conn = new mysqli(DBHOST, DBS['secure']['DBuser'], DBS['secure']['password'],
		DBS['secure']['name']);

	// Check connection
	if ($conn->connect_error) {
		//do something instead of dying
		die("Connection failed: " . $conn->connect_error);
	}
	$conn->query("SET NAMES UTF8");

	//login
	if ($_POST['formtype'] === 'login')
	{
		$errormsg = loginusr($conn);
	}
	else // register
	{
		$errormsg = registerusr($conn);
		$errormsg = loginusr($conn);
	}

	$conn->close();
}


loginon();

if ($errormsg === "")
{
	header("location: category.php"); // maybe change this to be the previous page?
}


?>
