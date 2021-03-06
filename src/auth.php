<?php

include_once "config.php";
include_once "dbFuncs.php";

if (session_status() == PHP_SESSION_NONE)
	session_start();

// returns whether the given password is secure or not
function passIsSecure($password)
{
	if (!is_string($password))
		return false;
	if (!USEANNOYINGPASSWORD)
		return true;
	if (strlen($password) < 8)
		return false;
	if (!preg_match('~[0-9]~', $password))
		return false;
	if (!preg_match('~[a-z]~', $password))
		return false;
	if (!preg_match('~[A-Z]~', $password))
		return false;
	return true;
}

$errormsg = null;

// does various checks and logs user in. will return an error message if it failed
function loginusr($conn)
{
	if (empty($_POST['username']) || empty($_POST['password']))
	{
		return ERREMPTYFIELD;
	}
	
	$result = $conn->query("SELECT * FROM users WHERE username='" . $_POST['username'] . "';");

	if ($result->num_rows !== 1)
		$result = $conn->query("SELECT * FROM users WHERE email='" . $_POST['username'] . "';");

	$row = $result->fetch_assoc();

	if ($result->num_rows !== 1)
		return ERRUSRNOTFOUND;
	else if (password_verify($_POST['password'], $row['password_hash']))
	{
		$status = getUserInfo($row['username'], 'statut');
		if (STATUSTOPERM[$status] != $row['permissions'])
			return ERRCHEATER;
		$_SESSION['username'] = $row['username'];
		return "";
	}
	else
		return ERRUSRNOTFOUND;
	return "";
}

// does various checks and registers user (does not log in) . will return an error message if it failed
function registerusr($conn)
{
	if (empty($_POST['fullname']) || empty($_POST['username']) || empty($_POST['email'])
		|| (!isset($_POST['userstatus']))
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
	
	if (!in_array($_POST['userstatus'], array_keys(USERSTATUSES))
		|| USERSTATUSES[$_POST['userstatus']] === 'admin')
		return ERRCHEATER;
	
	$query = "INSERT INTO users (username, email, password_hash, permissions)
				VALUES ('" . $_POST['username'] . "', '" . $_POST['email'] . "'," .
				" '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', '0');";

	$result = $conn->query($query);
	if ($result !== true)
		return ERRSQLINSI . " (secure)";

	if (addUserCentral($_POST['username'], $_POST['fullname'],
		$_POST['email'], $_POST['userstatus']) !== true)
		return ERRSQLINSI . " (central)";
	return "";
}

// does various checks and will use user input to log them in (and maybe register before that)
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

	$conn = connectDB('secure');

	//login
	if ($_POST['formtype'] === 'login')
	{
		$errormsg .= loginusr($conn);
	}
	else // register
	{
		$errormsg .= registerusr($conn);
		if (empty($errormsg))
			$errormsg .= loginusr($conn);
	}

	$conn->close();
}

loginon();

if ($errormsg === "")
{
	$logSuccess = true;
}


?>
