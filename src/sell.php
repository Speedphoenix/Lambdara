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
        <div class='vente'>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <table class="tab">
                    <tr>
                        <th colspan="2" style="text-align:center">Preparation de la mise en vente de votre article</th>
                    </tr>
                    <tr>
                        <td rowspan='4'>
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                <span> Select image to upload:</span><br>
                                <input class="upload_btn" type="file" name="fileToUpload" id="fileToUpload" required/>
                                <label for="fileToUpload">Choisir le fichier</label>
                                <input class='vente_btn' type="submit" value="Upload Image" name="submit_img"/>
                            </form>
                        </td>
                        <td>
                            <span>Nom de produit:</span>
                            <input class="field" type='text' name='product_name' placeholder="" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Description de produit:</span>
                            <!--<input class="field" type='text' name='product_description' placeholder="" required/>-->
                            <textarea class="field">Description de produit...</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Quantité</span>
                            <input class="field" type='number' name='number_of_products' placeholder="" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Prix unitaire</span>
                            <input class="field" type='number' name='unit_price' placeholder="" required/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input class='vente_btn' type="submit" value="Mettre le produit" name="submit"/></td>
                    </tr>
                </table>
                </form>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
