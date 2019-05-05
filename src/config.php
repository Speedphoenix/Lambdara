<?php

define("SITENAME", "Λara");
define("SITENAMEASCII", "Lambdara");

define("TESTING", false);

define("SELLERSCANBUY", true);

define("REMOVEIMAGES", true);

define("DEFAULTCATEG", "all");

define("POSSIBLECATEGS", array(
	"all" => "Tout",
	"livres" => "Livres",
	"musique" => "Musique",
	"vetements" => "Vetements",
	"sportloisir" => "Sport et Loisir"));


define("CHOIXDETRI", array(
	"date_ajout-do" => "Date d'ajout↑",
	"date_ajout-up" => "Date d'ajout↓",
	"prix-do" => "Prix↑",
	"prix-up" => "Prix↓",
	"note-up" => "Note↓",
	"note-do" => "Note↑",
	"nom-up" => "Nom↓",
	"nom-do" => "Nom↑",
	"popularite-up" => "Popularité↓",
	"popularite-do" => "Popularité↑",
	"quantite-up" => "Quantité disponible↓",
	"quantite-do" => "Quantité disponible↑",
	"vendeur_username-up" => "Vendeur↓",
	"vendeur_username-do" => "Vendeur↑",
	"categorie-up" => "Catégorie↓",
	"categorie-do" => "Catégorie↑",
));

define("DEFAULTTRI", "popularite-up");

define("DATESORT", array(
	"ttt" => "Tout le temps",
	"1" => "1 mois",
	"2" => "2 mois",
	"3" => "3 mois"));

define("DEFAULTDATESORT", "ttt");

define("DEFAULTPRICESORT", 250);
define("MINPRICESORT", 0);
define("MAXPRICESORT", 500);

define("POSSIBLEPRICESORT", range(MINPRICESORT, MAXPRICESORT, 1));

define("SERVERROOT", $_SERVER['DOCUMENT_ROOT']);
define("IMGDIR", "/images/");
define("MAXIMGSIZE", 2000000); //2MB ?

/*
define ("DEFAULTBCGIMG", url('https://www.doctorkweightloss.com/wp-content/uploads/Default-background-image.png'));
//https://www.doctorkweightloss.com/default-background-image/ SOURCE
define ("DEFAULTBCGIMG", url('https://cdn1.vectorstock.com/i/1000x1000/77/30/default-avatar-profile-icon-grey-photo-placeholder-vector-17317730.jpg'));
//https://www.vectorstock.com/royalty-free-vector/default-avatar-profile-icon-grey-photo-placeholder-vector-17317730 SOURCE
*/


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

define("STATUSTOPERM", array(
	0 => 0,
	1 => 0,
	2 => 1)
);

define("USERSTATUSES", array(
	0 => 'buyer',
	1 => 'seller',
	2 => 'admin'));

define("TYPECARDID", array(
	0 => 'visa',
	1 => 'mastercard',
	2 => 'amex'));

// POUR TESTER. devra proprement être enlevé et remplacé par les données prises de la BD

/*$testitems = array(
	array(
		"ID" => 129,
		"photo" => "https://5.imimg.com/data5/XX/BC/MY-71755908/school-book-250x250.jpg",
		"nom"=>"Les misérables, Victor Hugo",
		"catégorie"=>"livre",
		"date_ajout" => time(),
		"prix" => 45,
		"note" => 3,
		"description" => "Un homme, Jean Valjean, a volé un pain parce qu'il avait faim et il est condamné au bagne comme forçat. Il parvient à s'évader et est ébergé par un évêque qui lui fait passer la nuit chez lui. Jean Valjean s'enfuit en emportant les chandeliers d'argent de l'évêque. Arrêté par la police, il risque le bagne à vie mais l'évêque le sauve en disant qu'il lui offert les chandeliers. Ce geste va bouleverser sa vie. A partir de ce moment, il se consacre à faire du bien autour de lui. Il recueille Cosette, une malheureuse, exploitée par des malfrats, les Thénardiers. Il l'éduque et l'aime comme sa fille. Cosette devient amoureuse de Marius et Jean Gabin se sacrifie pour sauver le jeune homme, blessé gravement lors de la révolution. Il meurt en voyant le jeune couple heureux auprès de lui.",
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
		"description" => "une peluche " . PHP_EOL . "muahaha",
		"popularité" => 409,
		"quantité" => 4
		),
	
);*/

define("SUCCESADD", "Article ajouté avec succes");

define("ERRUSRNOTFOUND", "Nom d'utilisateur ou mot de passe non valide");
define("ERRNAMETAKEN", "Un utilisateur avec ce nom existe déjà");
define("ERREMAILTAKEN", "Un utilisateur avec cet email existe déjà");
define("ERRUNSAFEPASS", "Mot de passe pas suffisament complexe");
define("ERRPASSNOMATCH", "Le mot de passe ne correspond pas à sa confirmation");
define("ERREMPTYFIELD", "Veuillez remplir les bons champs du formulaire");
define("ERRSQLINSI", "Problème d'insertion sql, voir les développeurs");
define("ERRCHEATER", "Please don't try to cheat the system");
define("ERRCARDNOTV", "Carte de crédit non valide");
define("ERRCARTEMPTY", "Votre panier est vide!");
define("ERRNOFILE", "Veuillez fournir un fichier");
define("ERRNOTIMG", "Veuillez fournir une image");
define("ERRFILESIZE", "Le fichier fourni est trop lourd");
define("ERRUPLOAD", "Une erreur est survenue lors de l'upload du fichier");

// what to do when the initial connection to a database fails
// this is a temporarily brutal way of doing things and will be changed in time
function failedSql($msg)
{
	die($msg);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function converthtmlspecialchars(&$tab)
{
	foreach ($tab as $key => $elem)
	{
		if ($key !== 'password' && $key !== 'confirm-password')
		{
			if (!is_array($elem))
				$tab[$key] = htmlspecialchars($elem, ENT_QUOTES);
			else
				converthtmlspecialchars($tab[$key]);
		}
	}
}

converthtmlspecialchars($_GET);
converthtmlspecialchars($_POST);

?>
