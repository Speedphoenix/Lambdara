<?php

include_once "config.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";
include_once "generic-displays.php";

if (isset($_GET['categ']) && in_array($_GET['categ'], array_keys(POSSIBLECATEGS)))
	$categ = $_GET['categ'];
else
	$categ = DEFAULTCATEG; // 'all'

if (isset($_GET['choix_de_tri']) && in_array($_GET['choix_de_tri'], array_keys(CHOIXDETRI)))
	$tri = $_GET['choix_de_tri'];
else
	$tri = DEFAULTTRI;

if (isset($_GET['date_sort_choice']) && in_array($_GET['date_sort_choice'], array_keys(DATESORT)))
	$date_sort = $_GET['date_sort_choice'];
else
	$date_sort = DEFAULTDATESORT;

if (isset($_GET['price_sort']) && in_array($_GET['price_sort'], array_keys(POSSIBLEPRICESORT)))
	$s_price = $_GET['price_sort'];
else
	$s_price = DEFAULTPRICESORT;

//ici on chargera tous les items à afficher à partir des BDD
//tableau de tableaux, chaque sous tableau contient les données de chaque truc

$filtrer=array($categ,$date_sort,$s_price);


$items = getAllItems($filtrer, $tri); // et le tri si besoin



$pageTitle = $categ . " items";

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
			</select><br><br>
			<select name="date_sort_choice">
				<option value="" selected disabled hidden>Depuis:</option>
				<?php
					foreach(DATESORT as $key => $val)
					{
						echo "<option value='$key'>$val</option>"; 
					}
				?>
			</select><br><br>
			<!--<?php/*
				echo "<input type='range' max=" . MAXPRICESORT . " min=" . MINPRICESORT . " value=" . $s_price . " name='price_sort' oninput='sort_price_outp.value=sort_price_inp.value'/><br>";*/
			?>-->
			<!--<output class='price_show' name='sort_price_show' id='sort_price_outp'></output><br>-->
			<input type="range" max='<?php echo MAXPRICESORT; ?>' min=<?php echo MINPRICESORT; ?>' value=<?php echo $s_price; ?>' name="sort_price" id="sort_price_inp" oninput="sort_price_outp.value=sort_price_inp.value"/><br>
			<div class="price_show"><output name="sort_price_show" id="sort_price_outp"><?php echo $s_price ?></output> $</div>
			<input class="btn" type='submit' value="C'est parti!">
		</form>
	</div>
</div>

<div id='articleListing'>

	<table class='articleUnique'>

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

