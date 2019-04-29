<?php

// ce fichier sert à gérer les additions dans le panier,
// et tous les trucs utiles en lien au panier (par exemple le nombre d'elements dedans)

include_once "config.php";
include_once "dbFuncs.php";

$a = itemExists(2);

$currShopcart = array();

if (isset($_COOKIE['shopcart']))
{
	$cookieCart = explode(COOKIESEP, $_COOKIE['shopcart']);
	foreach($cookieCart as $key => $elem)
	{
		//the first value is the item's ID, the second value is the number of items there
		$i = explode(COOKIEITEMSEP, $elem);

		if (is_numeric($i[1]) && ($i[1] > 0) && itemExists($i[0]))
		{
			if (!isset($currShopcart[$i[0]]))
				$currShopcart[$i[0]] = $i[1];
			else
				$currShopcart[$i[0]] += $i[1];
		}
	}
}

$cookiemapfunc = function($key, $elem) {
	return $key . COOKIEITEMSEP . $elem;
};

if (isset($_POST['addAmount']) && is_numeric($_POST['addAmount']) && $_POST['addAmount'] > 0 &&
	isset($_POST['addShopcart']) && itemExists($_POST['addShopcart']))
{
	if (!isset($currShopcart[$_POST['addShopcart']]))
		$currShopcart[$_POST['addShopcart']] = $_POST['addAmount'];
	else
		$currShopcart[$_POST['addShopcart']] += $_POST['addAmount'];

	setcookie('shopcart',
		implode(COOKIESEP, array_map($cookiemapfunc, array_keys($currShopcart), $currShopcart)),
		time() + COOKIEDURATION);
}

$nbShopcart = 0;
foreach ($currShopcart as $id => $i)
{
	$nbShopcart += $i;
}

?>
