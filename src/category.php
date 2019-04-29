<?php

include_once "config.php";

if (isset($_GET['categ']) && in_array($_GET['categ'], POSSIBLECATEGS))
	$categ = $_GET['categ'];
else
	$categ = DEFAULTCATEG; // 'all'

$pageTitle = $categ . " items";

//ici on chargera tous les items à afficher à partir des BDD
//tableau de tableaux, chaque sous tableau contient les données de chaque truc

$items = array(
	array(
		"img" => "https://5.imimg.com/data5/XX/BC/MY-71755908/school-book-250x250.jpg",
		"ID" => 129,
		"vendeur" => "leo",
		"prix" => 45,
		"date" => time(),
		"description" => "des livres" . PHP_EOL . "muahaha"
		),
	array(
		"img" => "https://static.fnac-static.com/multimedia/Images/7A/7A/D3/3F/4182906-1505-1540-1/tsp20171106100739/Peluche-mega-ours-beige-1-metre-40-sam-peluche-geante-140-cm.jpg",
		"ID" => 112,
		"vendeur" => "leo",
		"prix" => 57,
		"date" => (time() - 3600 * 24 * 30),
		"description" => "une peluche" . PHP_EOL . "muahaha"
		),
);


function showArticle($what)
{
	echo "<div class='article' id='" . $what["ID"] . "'>";
echo "pour l'instant vide
<form method='post' action=" . $_SERVER['PHP_SELF'] .">
<input type='number' name='addAmount' min='1'/>
<input type='hidden' name='addShopcart' value='" . $what["ID"] . "'>
<input type='submit' value='Add to cart'/>
</form>
";
	
	echo "</div>";
}

include_once "shopcart-general.php";

include "header.php";
?>

<div id='mainContainer'>
<?php
echo "items in cart: " . $nbShopcart;
?>
	<ul>

<?php

foreach ($items as $i)
{
	echo "<li>";
	showArticle($i);
	echo "</li>";
}
// tous les trucs à afficher ici
?>

	</ul>
</div>

<?php
include "footer.php";
?>

