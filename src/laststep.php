<?php
include_once "config.php";
include_once "dbFuncs.php";
include_once "generic-displays.php";
include_once "genericFuncs.php";

if (empty($_SESSION['username']))
	header("location: checkout.php"); 
	//this will in turn redirect to login, then back to checkout after logging in

$errormsg = "";

if (empty($_POST['adresse_ligne']) || empty($_POST['code_postal']) || empty($_POST['ville'])
	|| empty($_POST['pays']) || empty($_POST['telephone']))
{
	$errormsg = ERREMPTYFIELD;
}
else if (!empty($_POST['rememberaddr']))
{
	if (addAddr($_SESSION['username'], $_POST) !== true)
		return ERRSQLINSI . " (central)";
}

if (empty($_POST['type_carte']) || empty($_POST['num_carte']) || empty($_POST['date_exp'])
	|| empty($_POST['nom']) || empty($_POST['code_secur']))
{
	$errormsg = ERREMPTYFIELD;
}
else
{
	$dump = explode('/', $_POST['date_exp']);
	$properDate = $dump[1] . '-' . $dump[0] . '-00';
	$_POST['date_exp'] = strtotime($properDate);
	$_POST['num_carte'] = str_replace('-', '', $_POST['num_carte']); 
	$_POST['num_carte'] = str_replace(' ', '', $_POST['num_carte']); 
	$_POST['num_carte'] = str_replace('_', '', $_POST['num_carte']); 
	$_POST['num_carte'] = str_replace('/', '', $_POST['num_carte']); 
	if (!isValidCard($_POST))
		$errormsg .= " " . PHP_EOL . ERRCARDNOTV;
	if (!empty($_POST['remembercard']))
	{
		if (addCard($_SESSION['username'], $_POST) !== true)
			$errormsg .= ERRSQLINSI . " (secure)";
	}
}

/// if errormsg not empty send the guys back to checkout.php with the error in tow

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
