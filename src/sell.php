<?php

include_once "config.php";
include_once "dbFuncs.php";

$allFields = array('product_name', 'product_description', 'number_of_products', 'unit_price');

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



// separator



include "header.php";
?>

<div id='mainContainer'>
    <?php
if (!empty($errormsg))
	showError($errormsg);
    ?>
    <div class='clearfix'>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class='sell'>
                <table>
                    <tr>
                        <th>Preparation de la mise en vente de votre article</th>
                    </tr>
                    <tr>
                        <td rowspan='4'></td>
                        <td>
                            <span>Nom de produit:</span>
                            <input class="field" type='text' name='product_name' placeholder="" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Description de produit:</span>
                            <input class="field" type='text' name='product_description' placeholder="" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Quantité</span>
                            <input class="field" type='text' name='number_of_products' placeholder="" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Prix unitaire</span>
                            <input class="field" type='text' name='unit_price' placeholder="" required/>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>

<?php
include "footer.php";
?>
