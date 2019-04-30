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
		"ID" => 129,
		"photo" => "https://5.imimg.com/data5/XX/BC/MY-71755908/school-book-250x250.jpg",
		"nom"=>"Les misérables, Victor Hugo",
		"catégorie"=>"livre",
		"date_ajout" => time(),
		"prix" => 45,
		"note" => 3,
		"description" => "des livres" . PHP_EOL . "muahaha",
		"popularité" => 209,
		"quantité" => 24
		),
	array(
		"ID" => 112,
		"photo" => "https://static.fnac-static.com/multimedia/Images/7A/7A/D3/3F/4182906-1505-1540-1/tsp20171106100739/Peluche-mega-ours-beige-1-metre-40-sam-peluche-geante-140-cm.jpg",
		"nom"=>"Les misérables, Victor Hugo",
		"catégorie"=>"livre",
		"date_ajout" => (time() - 3600 * 24 * 30),
		"prix" => 57,
		"note" => 3,
		"description" => "une peluche" . PHP_EOL . "muahaha",
		"popularité" => 409,
		"quantité" => 4
		),
);


define("ERRUSRNOTFOUND", "Nom d'utilisateur ou mot de passe non valide");
define("ERRUSRNOTFOUND", "Nom d'utilisateur ou mot de passe non valide");


?>
