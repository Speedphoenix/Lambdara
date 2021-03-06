<?php
include_once "config.php";
include_once "dbFuncs.php";
include_once "generic-displays.php";
include_once "genericFuncs.php";
include_once "shopcart-general.php";

if (empty($_SESSION['username']))
	header("location: checkout.php"); 
	//this will in turn redirect to login, then back to checkout after logging in

$errormsg = "";


if (empty($_POST['adresse_ligne']) || empty($_POST['code_postal']) || empty($_POST['ville'])
	|| empty($_POST['pays']) || empty($_POST['telephone']))
{
	$errormsg .= ERREMPTYFIELD;
}
else if (!empty($_POST['rememberaddr']))
{
	if (!empty($_POST['adresse_ligne2']))
		$_POST['adresse_ligne'] .= $_POST['adresse_ligne2'];
	if (addAddr($_SESSION['username'], $_POST) !== true)
		return ERRSQLINSI . " (central)";
}

if (!isset($_POST['type_carte']) || empty($_POST['num_carte']) || empty($_POST['date_exp'])
	|| empty($_POST['nom']) || empty($_POST['code_secur']))
{
	$errormsg .= ERREMPTYFIELD;
}
else
{
	$dump = explode('-', $_POST['date_exp']);
	if (count($dump) !== 2 || !is_numeric($dump[1]) || !is_numeric($dump[0]))
		$errormsg .= " " . PHP_EOL . ERRCARDNOTV;
	else
	{
		$properDate = $dump[1] . '-' . $dump[0] . '-00';
		$_POST['date_exp'] = $properDate; //strtotime($properDate);
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
}

if (!empty($errormsg))
{
	$_SESSION['errormsg'] = $errormsg;
	header("location: checkout.php");
}

// from here on we look at the shopcart and make 'em pay + send email

// TODO remove the bought items 

if ($nbShopcart !== 0)
{
	$receipt = "";
	$total = 0;
	if (!empty($currShopcart))
	{
		$items = getFromIDs(array_keys($currShopcart));

		$receipt .= "<table class='em_table'>
		<tr>
			<th class='em_th'>Nom de l'article</th>
			<th class='em_th'>Quantité achetée</th>
			<th class='em_th'>Prix unitaire</th>
			<th class='em_th'>Prix total</th>
            <th class='em_th'>Image</th>
		</tr>";


		foreach ($items as $i)
		{
			if (!isset($currShopcart[$i['ID']]))
				continue;
			$receipt .= "<tr>
			<td class='em_td'>" . $i['nom'] . "</td>
			<td class='em_td'>" . $currShopcart[$i['ID']] . "</td>
			<td class='em_td'>" . $i['prix'] . "€</td>
			<td class='em_td'>" . ($currShopcart[$i['ID']] * $i['prix']) . "€</td>
            <td class='em_td'><img src='";
            if(substr($i['photo'],0,4)==='http')
                $receipt.=$i['photo'];
            else
                $receipt.="https://".$_SERVER['SERVER_NAME'] .$i['photo'];
            
        $receipt.="' width='100px' height='100px'></td>
			</tr>
            <tr>
                <th colspan='5' class='em_th'>Description:</th>
            </tr>
            <tr>
                <td colspan='5' class='em_td'>".$i['description']." </td>
            </tr>";
			updateInDb('Articles', array(
				'quantite' => $i['quantite'] - $currShopcart[$i['ID']],
				'popularite' => $i['popularite'] + $currShopcart[$i['ID']]
			), "ID='" . $i['ID'] . "'");

			//updateItemInfo($i['ID'], 'quantite', $i['quantite'] - $currShopcart[$i['ID']]);

			$total += ($currShopcart[$i['ID']] * $i['prix']); 
		}
		$receipt .= "
        <tr>
		<td class='em_td' colspan='5'>
		Total: $total" . "€
		</td>
		</tr>
		</table>";
	}

	doPayment($total, $_POST);
	clearShopcart();

	//now to send the mail

	$to = getUserInfo($_SESSION['username'], 'email');

	// Subject
	$subject = "Votre commande";

	// Message
	$message = "<html>
	<head>
		<meta charset='utf-8'/>
		<title>Votre commande</title>
	</head>
	<body>
		<h3>Votre commande a été effectuée avec succes</h3>
		$receipt
	</body>
	</html>";

	// To send HTML mail, the Content-type header must be set
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/html; charset=iso-8859-1";
	$headers[] = 'From:"Lambdara"';
	$headers[] = 'Content-Type:text/html; charset="utf-8"';
	$headers[] = 'Content-Transfer-Encoding: 8bit';

	// Mail it
	mail($to, $subject, $message, implode("\r\n", $headers));
}
else
	$errormsg = ERRCARTEMPTY;

$nbShopcart = 0;
if ($errormsg !== "")
	$pageTitle = "Commande effectuée";

include "header.php";
?>

<div id='mainContainer'>
	<h3>Votre commande a été effectuée avec succes</h3>
<?php
if (!empty($errormsg))
	showError($errormsg);
else
	echo $receipt;
?>
</div>

<?php
include "footer.php";
?>
