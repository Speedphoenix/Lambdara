<?php

include_once "config.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";
include_once "generic-displays.php";

if (empty($_SESSION['username']))
{
	header("location: category.php");
}
if (USERSTATUSES[getUserInfo($_SESSION['username'], 'statut')] !== 'admin')
	header("location: category.php");

$allusers = getAllUsers('central');
if (!empty($_POST['makeAdmin']))
{
	updateInDb('users', array('statut' => '2'), "username='" . $_POST['makeAdmin'] . "'", 'central');
	updateInDb('users', array('permissions' => '1'), "username='" . $_POST['makeAdmin'] . "'", 'secure');
}

if (!empty($_POST['delUser']))
{
	deleteItems(getUsersItems($_POST['delUser']), 2);
	delInDb('users', 'username',  array($_POST['delUser']), 'central');
	delInDb('users', 'username',  array($_POST['delUser']), 'secure');
}

$pageTitle = "Admin";

include "header.php";
?>

<div id='mainContainer' style="text-align: center">
	<table>
<?php
	foreach ($allusers as $elem)
	{
		echo "<tr>" . PHP_EOL;
		echo "<td>Username: " . $elem['username'] . "</td>" . PHP_EOL;
		echo "<td>Nom Complet: " . $elem['nom_complet'] . "</td>" . PHP_EOL;
		if ($elem['adress_id'] !== NULL)
			echo "<td>A une adresse enregistrée</td>" . PHP_EOL;
		else
			echo "<td>N'a pas d'adresse enregistrée</td>" . PHP_EOL;
		echo "<td>Email: " . $elem['email'] . "</td>" . PHP_EOL;
		echo "<td>Statut: " . USERSTATUSES[$elem['statut']] . "</td>" . PHP_EOL;
		echo "<td>";
		if (USERSTATUSES[$elem['statut']] !== 'admin')
		{
			echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
			<input type='hidden' name='makeAdmin' value='" . $elem['username'] . "'>
			<input type='submit' value='Faire de cet utilisateur un administrateur'>
			</form>";
		}
		echo "</td>";
		echo "<td>";
		if ($elem['username'] !== $_SESSION['username'])
		{
			echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
			<input type='hidden' name='delUser' value='" . $elem['username'] . "'>
			<input type='submit' value='Supprimer cet utilisateur'>
			</form>";
		}
		echo "</td>";
		echo "</tr>" . PHP_EOL;
	}
?>
	</table>
</div>

<?php
include "footer.php";
?>
