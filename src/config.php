<?php

define("DEFAULTCATEG", "all");

define("POSSIBLECATEGS", array(
	"all",
	"livres",
	"musique",
	"vetements",
	"sportloisir"));

define("COOKIESEP", ';');
define("COOKIEITEMSEP", ':');

define("COOKIEDURATION", (365 * 24 * 3600));

// THIS IS NOT A SECURE WAY OF DOING THINGS
// but we chose to use it as this is only a school project
define("DBS", array(
	"secure" => array(
		"name" => "id9327242_secure",
		"DBuser" => "id9327242_root",
		"password" => "rootroot"),
	"central" => array(
		"name" => "id9327242_central",
		"DBuser" => "id9327242_root2",
		"password" => "rootroot")
	));

define("DBHOST", "localhost");

// POUR TESTER. devra proprement être enlevé et remplacé par les données prises de la BD
$testitems = array(
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


define("ERRUSRNOTFOUND", "Nom d'utilisateur ou mot de passe non valide");
define("ERRUSRNOTFOUND", "Nom d'utilisateur ou mot de passe non valide");


?>
