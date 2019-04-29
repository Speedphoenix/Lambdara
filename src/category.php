<?php

include_once "config.php";

if (isset($_GET['categ']) && in_array($_GET['categ'], POSSIBLECATEGS))
	$categ = $_GET['categ'];
else
	$categ = DEFAULTCATEG; // 'all'

$pageTitle = $categ . " items";

//ici on chargera tous les items à afficher à partir des BDD
//tableau de tableaux, chaque sous tableau contient les données de chaque truc

$items = $testitems;


include_once "shopcart-general.php";
include_once "generic-displays.php";

include "header.php";
?>

<div id='mainContainer'>
<?php
echo "items in cart: " . $nbShopcart;
?>
	<table>

<?php

foreach ($items as $i)
{
	echo "<tr><td>";
	showArticle($i);
// tous les trucs à afficher ici
	echo "</td></tr>";
}
?>

	</table>
</div>

<?php
include "footer.php";
?>

