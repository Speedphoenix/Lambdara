<?php

include_once "config.php";
include_once "dbFuncs.php";

//on verifie que l'article est bien passé
if (empty($_GET['ID']))
    header("location: category.php"); // ou bien une 404

$itemID = $_GET['ID']; //on set notre article avec celui de la BDD correspondant à l'id récupéré

//on vérifie que la clé de l'article passé existe bien
if (!itemExists($item["ID"]))
    header("location: 404.php");

$article = getFromIDs(array($_GET['ID']))[0];

$pageTitle = "article".$itemID;

//ici on chargera tous les items à afficher à partir des BDD
//tableau de tableaux, chaque sous tableau contient les données de chaque truc

include_once "shopcart-general.php";
include_once "generic-displays.php";

include "header.php";
?>

<div>
    <?php
    showSingleArticle($article); 
    ?>   
</div>
