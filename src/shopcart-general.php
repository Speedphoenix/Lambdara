<?php

// ce fichier sert à gérer les additions dans le panier,
// et tous les trucs utiles en lien au panier (par exemple le nombre d'elements dedans)

include_once "config.php";
include_once "dbFuncs.php";
include_once "generic-displays.php";

$currShopcart = array();

// basic limiting of vaiables. can't have more items in the cart than are currently available
function limitItemNB()
{
	global $currShopcart;
	$incartitems = getFromIDs(array_keys($currShopcart));

	foreach ($incartitems as $i)
	{
		if ($currShopcart[$i['ID']] > $i['quantite'])
		{
			$currShopcart[$i['ID']] = $i['quantite'];
		}
	}
}


if (isset($_COOKIE['shopcart']))
{
	$cookieCart = explode(COOKIESEP, $_COOKIE['shopcart']);
	foreach($cookieCart as $key => $elem)
	{
		//the first value is the item's ID, the second value is the number of items there
		$i = explode(COOKIEITEMSEP, $elem);

		if (is_numeric($i[1]) && ($i[1] > 0) && itemExists($i[0]))
		{
			$currShopcart[$i[0]] = $i[1];
		}
	}
}

// mapped funtion to make strings out of the (item-amount) sets
$cookiemapfunc = function($key, $elem) {
	return $key . COOKIEITEMSEP . $elem;
};

if (isset($_POST['addAmount']) && is_numeric($_POST['addAmount']) && $_POST['addAmount'] >= 0 &&
	isset($_POST['addShopcart']) && itemExists($_POST['addShopcart']))
{
	$currShopcart[$_POST['addShopcart']] = $_POST['addAmount'];
}

limitItemNB();

setcookie('shopcart',
	implode(COOKIESEP, array_map($cookiemapfunc, array_keys($currShopcart), $currShopcart)),
	time() + COOKIEDURATION);


$nbShopcart = 0;
foreach ($currShopcart as $id => $i)
{
	$nbShopcart += $i;
}

//empties the shopcart in the user's cookies
function clearShopcart()
{
	// setting the expiration date in the past will delete the cookie
	// apparently that's the right way to do it
	setcookie('shopcart', "", time() - 3600);
}

?>
