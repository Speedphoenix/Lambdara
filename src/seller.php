<?php

include_once "config.php";
include_once "genericFuncs.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";

if (empty($_SESSION['username']))
{
	$_SESSION['previouspage'] = $_SERVER['PHP_SELF'];
	header("location: login.php");
}
if (USERSTATUSES[getUserInfo($_SESSION['username'], 'statut')] !== 'buyer')
	header("location: category.php");

include "header.php";
?>

<div id='mainContainer'>
<?php
// tous les trucs à afficher ici
?>
</div>

<?php
include "footer.php";
?>
