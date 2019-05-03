<?php





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
