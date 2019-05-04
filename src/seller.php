<?php

include_once "config.php";
include_once "genericFuncs.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";

/*if (empty($_SESSION['username']))
{
	$_SESSION['previouspage'] = $_SERVER['PHP_SELF'];
	header("location: login.php");
}
if (USERSTATUSES[getUserInfo($_SESSION['username'], 'statut')] !== 'buyer')
	header("location: category.php");
*/
$nom_compl = getUserInfo($_SESSION['username'], 'nom_complet');
//$bckimg = getUserInfo($_SESSION['username'], 'img_couverture');
$profimg = getUserInfo($_SESSION['username'], 'img_profil');

//if(empty($bckimg))
    $bckimg='https://www.doctorkweightloss.com/wp-content/uploads/Default-background-image.png';



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


include "header.php";
?>

<div id='mainContainer'>
<?php
	if (!empty($errormsg))
		showError($errormsg);
?>
    <div class='clearfix'>
		<div class='vendeur'>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <table class="tab">
                    <tr>
                        <?php
                            echo "<th class='bkg' style='background-image: url($bckimg);'>";
                        ?>
                            <input class="upload_btn" type="file" name="fileToUpload" id="fileToUpload" required/>
                            <label style="margin:auto; margin-top:150px; margin-left:75%; width:23%;"  for="fileToUpload">Changer photo de couverture</label>
                        </th>
                    </tr>
                    <tr><td></td></tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
