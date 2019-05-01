<?php

include_once "config.php";
include_once "dbFuncs.php";

if (isset($_GET['categ']) && in_array($_GET['categ'], array_keys(POSSIBLECATEGS)))
	$categ = $_GET['categ'];
else
	$categ = DEFAULTCATEG; // 'all'

if (isset($_GET['choix_de_tri']) && in_array($_GET['choix_de_tri'], array_keys(CHOIXDETRI)))
	$tri = $_GET['choix_de_tri'];
else
	$tri = DEFAULTTRI;

$pageTitle = $categ . " items";

//ici on chargera tous les items à afficher à partir des BDD
//tableau de tableaux, chaque sous tableau contient les données de chaque truc

$items = getAllItems($categ); // et le tri si besoin


include_once "shopcart-general.php";
include_once "generic-displays.php";

include "header.php";
?>
<div id="mainContainer">
<div id="leftpart" class="clearfix">
    <div class="column search">
        <input class="field" name="q" type="text" placeholder="Rechercher" /><br>
        <input class="btn" type="submit" value="Rechercher" /><br><br>
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="get" >
            <select name='categ'>
                <option value="" selected disabled hidden>Categorie</option>
                <?php
                    foreach(POSSIBLECATEGS as $key => $val)
                    {
                        echo "<option value='$key'>$val</option>"; 
                    }
                ?>
            </select><br><br>
            <select name="choix_de_tri">
                <option value="" selected disabled hidden>Trier par</option>
                <?php
                    foreach(CHOIXDETRI as $key => $val)
                    {
                        echo "<option value='$key'>$val</option>"; 
                    }
                ?>
            </select>
			<input class="btn" type='submit' value="C'est parti!">
        </form>
    </div>
</div>

<div id='articleListing'>

	<table>

<?php

foreach ($items as $i)
{
	echo "<tr><td>";
	showArticle($i);
// tous les trucs à afficher ici
	echo "</td></tr>";
}
?>

	</table>
</div><!--
<div id="upperpart" class="clearfix">
    <div  class="column search">
        <input class="field" name="q" type="text" placeholder="Rechercher" /><br>
        <input class="btn" type="submit" value="Rechercher" />
    </div>
</div>
-->
</div>
<?php
include "footer.php";
?>

