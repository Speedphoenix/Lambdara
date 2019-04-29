<?php

include_once "config.php";

if (isset($_GET['categ']) && in_array($_GET['categ'], POSSIBLECATEGS))
	$categ = $_GET['categ'];
else
	$categ = DEFAULTCATEG; // 'all'

$pageTitle = $categ . "items";

//ici on chargera tous les items à afficher à partir des BDD
//tableau de tableaux, chaque sous tableau contient les données de chaque truc

$items = array(
	array(
		"img" => "https://5.imimg.com/data5/XX/BC/MY-71755908/school-book-250x250.jpg",
		"ID" => 129,
		"vendeur" => "leo",
		"prix" => 45,
		"date" => date(),
		"description" => "des livres" . PHP_EOL . "muahaha"
		),
	array(
		"img" => "https://static.fnac-static.com/multimedia/Images/7A/7A/D3/3F/4182906-1505-1540-1/tsp20171106100739/Peluche-mega-ours-beige-1-metre-40-sam-peluche-geante-140-cm.jpg",
		"ID" => 112,
		"vendeur" => "leo",
		"prix" => 57,
		"date" => (date() - 3600 * 24 * 30),
		"description" => "une peluche" . PHP_EOL . "muahaha"
		),
);


function showArticle($what)
{
	echo "<div class='article' id='" . $what["ID"] . "'>";
	echo "pour l'instant vide";
	echo "</div>";
}

include "header.php";
?>

<div id='mainContainer'>
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

