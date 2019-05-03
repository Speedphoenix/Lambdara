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
if (USERSTATUSES[getUserInfo($_SESSION['username'], 'statut')] !== 'buyer')
	header("location: category.php");

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
		$("input[name='date_exp']").val("<?php
		$textdate = explode('-', $card['date_exp']);
		echo $textdate[1] . "-" . substr($textdate[0], 2);
		?>");
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

<div id='mainContainer' class="clearfix">
<?php
if (!empty($errormsg))
	showError($errormsg);
?>
    <div class="payment">
        <form action='laststep.php' method='post'>
            <table class="tab">
                <tr>
                    <td>
                        Adresse: <br>
                        <input class="field" type='text' name='adresse_ligne' placeholder="Addresse"/>
                    </td>
                    <td rowspan="2">
                        Info carte:<br>
                        <?php
                            foreach (TYPECARDID as $key => $elem)
                            {
                                /*echo "<label><input style='margin: 10px;' type='radio' name='type_carte' value='$key'/>  ". $elem. "</label>";*/
                                echo "<label><input style='margin: 10px;' type='radio' name='type_carte' value='$key'/><div class='$elem'> </div></label>";
                            }
                        ?>
                    </td>
                </tr>
                    <td><input class="field" type='text' name='adresse_ligne2' placeholder="Complement d'adresse"/></td>
                <tr>
                    <td><input class="l_field" type='text' name='code_postal' placeholder="Code postal" required/></td>
                    <td>
                        <span>Numéro de Carte:</span>
                        <input class="field" type='text' name='num_carte' placeholder="XXXX-XXXX-XXXX-XXXX" required/>
                    </td>
                </tr>
                    <td><input class="l_field" type='text' name='ville' placeholder="Ville" required/></td>
                    <td>
                        <span>Date d'expiration:</span>
                        <input class="field" type='text' name='date_exp' placeholder="MM-YY" required/>
                    </td>
                <tr>
                    <td><input class="l_field" type='text' name='pays' placeholder="Pays" required/></td>
                    <td>
                        <span>Nom sur la carte:</span>
                        <input class="field" type='text' name='nom' placeholder="Jane Doe" required/>
                    </td>
                </tr>
                    <td><input class="l_field" type='text' name='telephone' placeholder="Telephone" required/></td>
                    <td>
                        <span>Cryptogramme visuel:</span>
                        <input class="field" type='text' name='code_secur' placeholder="XXX" required/>
                    </td>
                <tr>
                </tr>
                <td><label><input type='checkbox' name='rememberaddr' checked/>  Mémoriser l'adresse de livraison</label></td>
                <td><label><input type='checkbox' name='remembercard'/>  Mémoriser la carte de crédit</label></td>
             <!--
                <input type='text' name='adresse_ligne' placeholder="Addresse" required/>
                <input type='text' name='adresse_ligne2' placeholder="Addresse"/>
                <input type='text' name='code_postal' placeholder="Code postal" required/>
                <input type='text' name='ville' placeholder="Ville" required/>
                <input type='text' name='pays' placeholder="Pays" required/>
                <input type='text' name='telephone' placeholder="Telephone" required/>
                <label><input type='checkbox' name='rememberaddr' checked/>Mémoriser l'adresse de livraison</label>

                <?php
                foreach (TYPECARDID as $key => $elem)
                {
                    echo "<label><input type='radio' name='type_carte' value='$key'/>$elem</label>";
                }
                ?>
                <span>Numéro de Carte:</span>
                <input type='text' name='num_carte' placeholder="XXXX-XXXX-XXXX-XXXX" required/>
                <span>Date d'expiration:</span>
                <input type='text' name='date_exp' placeholder="MM/YY" required/>
                <span>Nom sur la carte:</span>
                <input type='text' name='nom' placeholder="Jane Doe" required/>
                <span>Cryptogramme visuel:</span>
                <input type='text' name='code_secur' placeholder="XXX" required/>
                <span>Numéro de Carte:</span>
                <label><input type='checkbox' name='remembercard'/>Mémoriser la carte de crédit</label>-->
            
                <tr><td colspan="2"><input class="btn" type='submit' value="Poursuivre"/></td></tr>
            </table>
        </form>
    </div>
</div>

<?php
include "footer.php";
?>
