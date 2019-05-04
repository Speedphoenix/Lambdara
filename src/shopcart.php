<?php

include_once "config.php";
include_once "shopcart-general.php";
include_once "generic-displays.php";

$items = getFromIDs(array_keys($currShopcart));

$pageTitle = "Votre Panier";

include "header.php";
?>

<div id='mainContainer'>
<?php
if (empty($currShopcart))
	showError(ERRCARTEMPTY);
else
{
?>
    <div class="basket">
	   <table class="tab">
            <?php

            $total = 0;

            foreach ($items as $i)
            {
                if (!isset($currShopcart[$i['ID']]))
                    continue;
                echo "<tr style='border-bottom: 1px solid #ddd;'>";
                echo "<td>";
                echo "Nombre dans le panier: " . $currShopcart[$i['ID']] . "</br>";
                echo "Prix à l'unité: " . $i['prix'] . "€</br>";
                echo "Coût total: " . ($currShopcart[$i['ID']] * $i['prix']) . "€";
                $total += ($currShopcart[$i['ID']] * $i['prix']); 

                addToShopcartForm($i);

                echo "</td>";
                echo "<td>";
                showArticle($i);
                // tous les trucs à afficher ici
                echo "</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan='2'>";
            echo "Coût total: " . $total . "€";
            echo "</td>";
            echo "<td>";
            // tous les trucs à afficher ici
            echo "</td>";
            echo "</tr>";

            ?>
	   </table>
	   <a href="checkout.php"><button class="btn">Passer à la commande</button></a>

        <?php
        }
        ?>
    </div>
</div>

<?php
include "footer.php";
?>
