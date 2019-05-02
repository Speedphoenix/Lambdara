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
	echo "nombre dans le panier: " . $currShopcart[$i['ID']] . "</br>";
	echo "prix à l'unité: " . $i['prix'] . "</br>";
	echo "coût total: " . ($currShopcart[$i['ID']] * $i['prix']);
	$total += ($currShopcart[$i['ID']] * $i['prix']); 

	echo "<form method='post' action=" . $_SERVER['PHP_SELF'] .">
		<input type='number' name='addAmount' min='0'";

	if (isset($currShopcart) && isset($currShopcart[$i["ID"]]))
		echo "value='" . $currShopcart[$i["ID"]] . "'";

	echo "/>
		<input type='hidden' name='addShopcart' value='" . $i["ID"] . "'>
		<input type='submit' value='Add to cart'/>
	</form>";

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
	<a href="checkout.php"><button>Passer à la commande</button></a>
</div>

<?php
include "footer.php";
?>
