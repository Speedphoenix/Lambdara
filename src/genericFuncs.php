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

function isValidCard($card)
{
	/*
	if ($card['date_exp'] < time())
		return false;
	*/
	if (!is_numeric($card['num_carte']) || $card['num_carte'] < 0
		|| $card['num_carte'] > '9999999999999999')
		return false;
	if (!is_numeric($card['code_secur']) || $card['code_secur'] < 0
		|| $card['code_secur'] > '999')
		return false;
	if (!isset(TYPECARDID[$card['type_carte']]))
		return false;
	return true;
}


?>
