<?php
include_once "config.php";
include_once "dbFuncs.php";
include_once "generic-displays.php";

$errormsg = "";

if (empty($_POST['addresse_ligne']) || empty($_POST['code_postal']) || empty($_POST['ville'])
	|| empty($_POST['pays']) || empty($_POST['telephone']))
{
	$errormsg = ERREMPTYFIELD;
}

if (empty($_POST['type_carte']) || empty($_POST['num_carte']) || empty($_POST['date_exp'])
	|| empty($_POST['nom']) || empty($_POST['code_postal']))
{
	$errormsg = ERREMPTYFIELD;
}

include "header.php";
?>

<div id='mainContainer'>
<?php
if (!empty($errormsg))
	showError($errormsg);

// tous les trucs à afficher ici
?>
</div>

<?php
include "footer.php";
?>
