<?php

include_once "config.php";
include_once "genericFuncs.php";
include_once "dbFuncs.php";
include_once "generic-displays.php";

if (empty($_SESSION['username']))
{
	$_SESSION['previouspage'] = $_SERVER['PHP_SELF'];
	header("location: login.php");
}
if (USERSTATUSES[getUserInfo($_SESSION['username'], 'statut')] !== 'seller')
	header("location: category.php");

$allFields = array('nom', 'categorie', 'prix', 'description', 'quantite', 'video');
$notRequiredFields = array('video');

$errormsg = "";
$success = "";

if (isset($_POST['askedadd']))
{
	$isvalid = true;
	foreach ($allFields as $i)
	{
		if (empty($_POST[$i]) && !in_array($_POST[$i], $notRequiredFields))
		{
			$isvalid = false;
			break;
		}
	}
	if (!is_numeric($_POST['prix']))
		$isvalid = false;
	if ($_POST['categorie'] === 'all' || !isset(POSSIBLECATEGS[$_POST['categorie']]))
		$isvalid = false;
	if (!$isvalid)
		$errormsg = ERREMPTYFIELD;
	else
	{
		$dump = receiveImage('itemImage');
		if (is_array($dump))
			$filename = $dump['filename'];
		else
			$errormsg = $dump;
	}
	if ($errormsg === "")
	{
		$valuesToAdd = array();
		foreach ($allFields as $i)
		{
			$valuesToAdd[$i] = (empty($_POST[$i]) ? "" : $_POST[$i]);
		}
		$valuesToAdd['date_ajout'] = date("Y-m-d H:i:s");
		$valuesToAdd['photo'] = $filename;
		$valuesToAdd['popularite'] = '0';
		$valuesToAdd['note'] = '0';
		$valuesToAdd['vendeur_username'] = $_SESSION['username'];

		$itemId = addInDB('Articles', $valuesToAdd);
		if ($itemId !== false)
			$success = SUCCESADD;
	}
}

// separator


$pageTitle = "Nouvel article en vente";

include "header.php";
?>

<div id='mainContainer'>
<?php
	if (!empty($errormsg))
		showError($errormsg);
	if (!empty($success))
		showError($success);
?>
	<div class='clearfix'>
		<div class='vente'>
            <a href="seller.php"><button class='vente_btn' style="width:50%;">Votre profil</button></a>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post">
				<input type="hidden" name="askedadd" value="true"/>
				<table class="tab">
					<tr>
						<th colspan="2" style="text-align:center">
							Preparation de la mise en vente de votre article
						</th>
					</tr>
					<tr>
						<td rowspan='6'>
							<span> Select image to upload:</span><br>
							<input class="upload_btn" type="file" name="itemImage" id="itemImage" required/>
							<label for="itemImage">Choisir un fichier</label>
						</td>
						<td>
							<span>Nom du produit:</span>
							<input class="field" type='text' name='nom' required/>
						</td>
					</tr>
					<tr>
						<td>
							<select name='categorie'>
								<?php
									foreach(POSSIBLECATEGS as $key => $val)
									{
										if ($key === 'all')
											continue;
										echo "<option value='$key'>$val</option>";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<span>Description du produit:</span>
							<!--<input class="field" type='text' name='product_description' placeholder="" required/>-->
							<textarea name="description" class="field" placeholder="Description du produit..."></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<span>Quantité</span>
							<input class="field" type='number' name='quantite' required/>
						</td>
					</tr>
					<tr>
						<td>
							<span>Prix unitaire</span>
							<input class="field" type='number' name='prix' required/>
						</td>
					</tr>
					<tr>
						<td>
							<span>ID de la video youtube</span>
							<input class="field" type='text' name='video'/>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input class='vente_btn' type="submit" value="Mettre le produit" name="submit"/></td>
					</tr>
                    <!--<tr>
                        <td colspan="2"><a href="seller.php"><button class='vente_btn'>Votre profile</button></a></td>
					</tr>-->
				</table>
				</form>
		</div>
	</div>
</div>

<?php
include "footer.php";
?>
