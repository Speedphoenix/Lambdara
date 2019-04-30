<?php

include_once "config.php";

//ce fichier contient les fonctions génériques pour certaines opérations avec la base de donnée

//make this check in the datbase its existence
function itemExists($whatID)
{
	//à changer
	return true;
}

// returns an array of items from the DB that have these IDs
// $IDs is an array of ids
function getFromIDs($IDs)
{
	// SELECT FROM items WHERE id=$IDs[$i]
	

	// below is for testing purposes, make sure you remove afterwards
	global $testitems;
	return $testitems;
}

function addUserCentral($username, $fullname, $email)
{
	return true;
}

?>
