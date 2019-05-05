<?php

include_once "config.php";
include_once "genericFuncs.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";

if (empty($_SESSION['username']))
	$userstatus = 0;
else
	$userstatus = getUserInfo($_SESSION['username'], 'statut');
if (USERSTATUSES[$userstatus] !== 'admin'
	&& USERSTATUSES[$userstatus] !== 'seller')
{
	header("location: " . getPrevPage("category.php"));
}

if (empty($_POST['deleteItems']))
	header("location: " . getPrevPage("category.php"));

//this will only give items that exist
$items = getFromIDs($_POST['deleteItems'], "");

deleteItems($items);

$itemsToDelete = arheader("location: " . getPrevPage("category.php"));

?>
