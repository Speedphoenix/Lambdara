<?php

include_once "config.php";
include_once "genericFuncs.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";

if (empty($_SESSION['username']))
{
	$_SESSION['previouspage'] = $_SERVER['PHP_SELF'];
	header("location: login.php");
}

$addr = getAdress($_SESSION['username']);
$card = getCB($_SESSION['username']);

if (!isset($errormsg))
	$errormsg = "";

if (!empty($_SESSION['errormsg']))
{
	$errormsg .= $_SESSION['errormsg'];
	unset($_SESSION['errormsg']);
}

include "header.php";

if ($addr !== false)
{
?>

<script type="text/javascript">
	$(document).ready(function() {
		$("input[name='adresse_ligne']").val("<?= $addr['adresse_ligne'] ?>");
		$("input[name='code_postal']").val("<?= $addr['code_postal'] ?>");
		$("input[name='ville']").val("<?= $addr['ville'] ?>");
		$("input[name='pays']").val("<?= $addr['pays'] ?>");
		$("input[name='telephone']").val("<?= $addr['telephone'] ?>");
	});
</script>

<?php
}

if ($card !== false)
{
?>

<script type="text/javascript">
	$(document).ready(function() {
		$("input[name='num_carte']").val("<?= $card['num_carte'] ?>");
		$("input[name='date_exp']").val("<?= $card['date_exp'] ?>");
		$("input[name='nom']").val("<?= $card['nom'] ?>");
		$("input[name='code_secur']").val("<?= $card['code_secur'] ?>");
		$("input[name='type_carte'][value='<?= $card['type_carte'] ?>']").prop("checked", true);
		$("input[name='remembercard']").prop("checked", true);
	});
</script>

<?php
}
else // default stuff
{
?>

<script type="text/javascript">
	$(document).ready(function() {
		$("input[name='type_carte'][value='0']").prop("checked", true);
	});
</script>

<?php
}

?>

<div id='mainContainer'>
<?php
if (!empty($errormsg))
	showError($errormsg);
?>
	<form action='laststep.php' method='post'>
		<input type='text' name='adresse_ligne' placeholder="Addresse"/>
		<input type='text' name='code_postal' placeholder="Code postal"/>
		<input type='text' name='ville' placeholder="Ville"/>
		<input type='text' name='pays' placeholder="Pays"/>
		<input type='text' name='telephone' placeholder="Telephone"/>
		<label><input type='checkbox' name='rememberaddr' checked/>Mémoriser l'adresse de livraison</label>

		<?php
		foreach (TYPECARDID as $key => $elem)
		{
			echo "<label><input type='radio' name='type_carte' value='$key'/>$elem</label>";
		}
		?>
		<span>Numéro de Carte:</span>
		<input type='text' name='num_carte' placeholder="XXXX-XXXX-XXXX-XXXX"/>
		<span>Date d'expiration:</span>
		<input type='text' name='date_exp' placeholder="MM/YY"/>
		<span>Nom sur la carte:</span>
		<input type='text' name='nom' placeholder="Jane Doe"/>
		<span>Cryptogramme visuel:</span>
		<input type='text' name='code_secur' placeholder="XXX"/>
		<span>Numéro de Carte:</span>
		<label><input type='checkbox' name='remembercard'/>Mémoriser la carte de crédit</label>

		<input type='submit' value="Poursuivre"/>
	</form>
</div>

<?php
include "footer.php";
?>
