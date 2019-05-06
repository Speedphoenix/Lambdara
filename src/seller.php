<?php

include_once "config.php";
include_once "genericFuncs.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";

$isowner = false;
if (!empty($_GET['user']))
{
	if (getUserInfo($_GET['user'], false) !== false)
		$whatuser = $_GET['user'];
}
if (!empty($_SESSION['username']))
{
	if (empty($whatuser))
		$whatuser = $_SESSION['username'];
	if ($whatuser === $_SESSION['username'])
		$isowner = true;
}
if (empty($whatuser))
{
	$_SESSION['previouspage'] = $_SERVER['PHP_SELF'];
	header("location: login.php");
}

if (USERSTATUSES[getUserInfo($whatuser, 'statut')] !== 'seller')
	header("location: category.php");

// update the user's info/images in the db
function updateUser()
{
    global $errormsg;
	global $isowner;
	if (!$isowner)
	{
		$errormsg = ERRCHEATER;
		return ;
	}
	$result = true;
    $values_to_change=array();
    if(!empty($_POST['email']))
        $values_to_change["email"] = $_POST['email'];
    if(!empty($_POST['surname']) && !empty($_POST['name']))
        $values_to_change["nom_complet"] = $_POST['surname']." ".$_POST['name'];
    
    $dump = receiveImage('fileToUpload1');
    if (is_array($dump))
        $values_to_change['img_couverture'] = $dump['filename'];
    else
        $errormsg = $dump;

        $dump = receiveImage('fileToUpload2');
    if (is_array($dump))
        $values_to_change['img_profil'] = $dump['filename'];
    else
        $errormsg = $dump;
    
   /* if(!empty($_POST['fileToUpload1']))
        $values_to_change["img_couverture"] = $_POST['fileToUpload1'];
    if(!empty($_POST['fileToUpload2']))
        $values_to_change["img_profil"] = $_POST['fileToUpload2'];*/
    //var_dump($values_to_change);
    if(!empty($values_to_change))     
		$result = updateInDb('users', $values_to_change, "username='" . $_SESSION['username'] . "'");
	

	return ($result === true);
}

if(isset($_POST["submit"]))
    updateUser();

$nom_compl = getUserInfo($whatuser, 'nom_complet');
$bckimg = getUserInfo($whatuser, 'img_couverture');
$profimg = getUserInfo($whatuser, 'img_profil');

if(empty($bckimg))
    $bckimg='https://www.doctorkweightloss.com/wp-content/uploads/Default-background-image.png';

if(empty($profimg))
    $profimg='https://profiles.utdallas.edu/img/default.png';



$errormsg = "";

if (isset($_POST['askedadd']))
{
	$isvalid = true;
	foreach ($allFields as $i)
	{
		if (empty($_POST[$i]))
		{
			$isvalid = false;
			break;
		}
	}
	if (!$isvalid)
		$errormsg = ERREMPTYFIELD;
}

$items = getUsersItems($whatuser);

$pageTitle = $whatuser;

include "header.php";
?>

<div id='mainContainer'>
<?php
	if (!empty($errormsg))
		showError($errormsg);
?>
    <div class='clearfix'>
		<div class='vendeur'>
			<?php
				/*if ($isowner)
					echo '<form action="seller.php" method="post" enctype="multipart/form-data">';
				*/
			?>
                <table class="tab">
                    <tr>
                        <?php
                        echo "<th class='bkg' colspan='3' style='background-image: url(\"$bckimg\");'>";
						if ($isowner)
						{
						?>
                            <input form="updateUserForm" class="upload_btn" type="file" name="fileToUpload1" id="fileToUpload1" />
                            <label style="margin:auto; margin-top:150px; margin-left:75%; width:23%;"  for="fileToUpload1">Changer photo de couverture</label>
						<?php
						}
                        ?>
                        </th>
                    </tr>
                    <tr>
                        <?php
                            echo"<td class='prof' style='width:30%; background-image: url(\"$profimg\");'>";
                            /*echo"<div  style='width:auto; margin:auto; margin-top:10%; margin-left:400px;'>$nom_compl</div> ";*/
							if ($isowner)
							{
							?>
								<input form="updateUserForm" class="upload_btn" type="file" name="fileToUpload2" id="fileToUpload2" />
								<label style="margin:auto; margin-top:270px; margin-right:100%; margin-left:13px; width:250px;"
									for="fileToUpload2">Changer photo de profil</label>
							<?php
							}
                        ?>
                        </td>
                        <td style='width:30%;'>
                            <?php
                                echo"<div style='width:80%; margin:auto; margin-bottom:100%; margin-top:10%; margin-left:20px;'><tit>Utilisateur:</tit><br><util>$nom_compl</util></div> ";
                            ?>
                        </td>
						<td style='width:40%; vertical-align:top;'>
							<?php
							if ($isowner)
							{
							?>
								<br><br>
								<form action="seller.php" method="post" enctype="multipart/form-data" id="updateUserForm">
								<span>Changer les informations:</span><br><br>
								<input class="field" type='text' name='surname' placeholder="Nom:" /><br><br>
								<input class="field" type='text' name='name' placeholder="Prenom:" /><br><br>
								<input class="field" type='text' name='email' placeholder="E-mail:" /><br><br>
								<input class="vend_btn" type='submit' name="submit" value="Enregistrer les changements">
								</form>
							<?php
							}
							?>
						</td>
                    </tr>
					<tr>
						<th style="text-align: left" colspan="3">Articles mis en vente par <?= $whatuser ?>:</th>
					</tr>
					<tr>
						<td colspan="3">
							<?php
								listArticles($items);
							/*
							<table class='articleUnique'>
								<?php
								foreach ($items as $i)
								{
									echo "<tr><td>";
									showArticle($i);
									echo "</td></tr>";
								}
							</table>
							*/
							?>
						</td>
					</tr>
                </table>
			<?php
				/*if ($isowner)
					echo '</form>';
				*/
			?>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
