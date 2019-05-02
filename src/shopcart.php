<?php

include_once "config.php";
include_once "shopcart-general.php";
include_once "generic-displays.php";

$items = getFromIDs(array_keys($currShopcart));

$pageTitle = "Votre Panier";

include "header.php";
?>

<div id='mainContainer'>
	<table>
<?php

$total = 0;

foreach ($items as $i)
{
	if (!isset($currShopcart[$i['ID']]))
		continue;
	echo "<tr>";
	echo "<td>";
	echo "nombres dans le panier: " . $currShopcart[$i['ID']] . "</br>";
	echo "prix à l'unité: " . $i['prix'] . "</br>";
	echo "coût total: " . ($currShopcart[$i['ID']] * $i['prix']);
	$total += ($currShopcart[$i['ID']] * $i['prix']); 
	echo "</td>";
	echo "<td>";
	showArticle($i);
	// tous les trucs à afficher ici
	echo "</td>";
	echo "</tr>";
}
echo "<tr>";
echo "<td>";
echo "total: " . $total; 
echo "</td>";
echo "<td>";
// tous les trucs à afficher ici
echo "</td>";
echo "</tr>";

?>
	</table>
	<form action="checkout.php" method="post"><input class="btn" type="submit" value="Passer à la commande"/></form>
</div>

<?php
include "footer.php";
?>
