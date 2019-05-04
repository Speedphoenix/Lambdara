<?php

if (session_status() == PHP_SESSION_NONE)
	session_start();

function receiveImage($nameInForm)
{
	if (empty($_FILES[$nameInForm])
		|| !file_exists($_FILES[$nameInForm]['tmp_name'])
		|| !is_uploaded_file($_FILES[$nameInForm]['tmp_name']))
		return ERRNOFILE;

	$fileBaseName = basename($_FILES[$nameInForm]["name"]);

	$correctImg = true;

	$imageFileType = strtolower(pathinfo($fileBaseName, PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	$isImage = getimagesize($_FILES[$nameInForm]["tmp_name"]);
	if ($isImage === false)
	{
		return ERRNOTIMG;
	}
	if ($_FILES[$nameInForm]['size'] > MAXIMGSIZE)
		return ERRFILESIZE;
	$i = 0;
	do
	{
		$i++;
		$target_file = SERVERIMGDIR . $i . $fileBaseName;
	} while (file_exists($target_file));

	if (move_uploaded_file($_FILES[$nameInForm]['tmp_name'], $target_file))
	{
		return array(
			0 => true,
			'filename' => CLIENTIMGDIR . $i . $fileBaseName
		);
	}
	else
		return ERRUPLOAD;
}

function makeGetUrl()
{
	if (empty($_GET))
		return "";
	$rep = "?";
	$getarraykey = array_keys($_GET);
	$lastKey = end($getarraykey);
	foreach ($_GET as $key => $elem)
	{	
		$rep .= "$key=$elem";
		if ($key !== $lastKey)
			$rep .= "&";
	}
	return $rep;
}

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

function doPayment($price, $card)
{
	return true;
}

?>
