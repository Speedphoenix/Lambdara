<?php

if (session_status() == PHP_SESSION_NONE)
	session_start();

// will properly take in the image uploaded and return an error message or the filename
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
		$target_file = SERVERROOT . IMGDIR . $i . $fileBaseName;
	} while (file_exists($target_file));

	if (move_uploaded_file($_FILES[$nameInForm]['tmp_name'], $target_file))
	{
		return array(
			0 => true,
			'filename' => IMGDIR . $i . $fileBaseName
		);
	}
	else
		return ERRUPLOAD;
}

// this will delete all the images given
function clearImages($images)
{
	foreach ($images as $elem)
	{
		$fileName = SERVERROOT . $elem;
		if (file_exists($fileName))
		{
			//this can not be undone
			unlink($fileName);
		}
	}
}

//will delete an Item
function deleteItems($items, $userstatus)
{
	$itemsToDelete = array();
	$imagesToDelete = array();

	foreach ($items as $elem)
	{
		if ((USERSTATUSES[$userstatus] !== 'admin')
			|| ($elem['vendeur_username'] === $_SESSION['username']))
		{
			delInDB('variation', 'article_id', array($elem['ID']));
			array_push($itemsToDelete, $elem['ID']);
			if(substr($elem['photo'],0,4)!=='http')
				array_push($imagesToDelete, $elem['photo']);
		}
	}

	if (REMOVEIMAGES)
		clearImages($imagesToDelete);

	delInDB('Articles', 'ID', $itemsToDelete);
}

//will return the part after an url with all the get variables
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

// sets the session variable to remember the previous page to come back to later using the get and post variables
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

// takes in the above function and returns what the currently previous page is
function getPrevPage($defaultpage = "category.php")
{
	setPrevPage();
	if (!empty($_SESSION['previouspage']))
		return $_SESSION['previouspage'];
	else
		return $defaultpage;
}

// some checks on whether a credit card is valid
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

// will eventually be implemented to process a payment
function doPayment($price, $card)
{
	return true;
}

?>
