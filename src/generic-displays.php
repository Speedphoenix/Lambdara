<?php

include_once "config.php";
include_once "genericFuncs.php";


// prints a pretty error
function showError($errmsg)
{
	echo "<h2 class='error'>$errmsg</h2>" . PHP_EOL;
}

// Prints a small article (those you can see in category.php or in the shopcart)
function showArticle($what)
{

	$lim = 120;
	if(strlen($what["description"])>$lim){
		$toto= "";
		for($i=0;$i<$lim-1;$i++){
			$toto[$i]=$what["description"][$i];
		}
		$toto[$lim]='.';
        $toto[$lim+1]='.';
		$toto[$lim+2]='.';
		$what["description"]=$toto;
	}
echo "<div id='articles'>";
echo "	<table class='articleUniqueTab'>

		  <tr>
		    <td rowspan='2'><a href='singleArticle.php?ID=" . $what['ID'] . "'><img src='".$what["photo"]."'width='100' height='100' style='float : left'/></a></td>
		    <th class='articleDetail'><a href='singleArticle.php?ID=" . $what['ID'] . "' >".$what["nom"]."</a></th>
		    <td class='articleDetail'>prix : ".$what["prix"]."€</td>
		    <td class='articleDetail'>note :".$what["note"]."/5</td>
		    <td class='articleDetail'>Quantité restante : ".$what['quantite']."</td>
		  </tr>

		  <tr>
		  	<td colspan='4'>".$what["description"]."</td>
		  </tr>
		</table> ";
echo "</div>";
}

// the small form next to an item to add it to cart
function addToShopcartForm($what)
{
	global $currShopcart;
	echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . makeGetUrl() . "'>
		<input class='field' type='number' name='addAmount' min='0'";

	if (isset($currShopcart[$what["ID"]]))
		echo "value='" . $currShopcart[$what["ID"]] . "'";
		
		echo "/>
		<input type='hidden' name='addShopcart' value='" . $what["ID"] . "'>
		<input class='basket_btn' type='submit' value='Add to cart'/>
	</form>";
}

//affichage des variations d'articles s'ils existent
function repeatVariation($variation)
{
	foreach ($variation as $typevari => $i) 
	{
		echo "<tr><td>";

	    echo $typevari;

		echo "<select name='choix_de_tri'>
	                <option value='' selected>Choisir $typevari</option>";
	  	foreach($i as $varindividuelle)
	    {
	    	echo "<option>" . $varindividuelle["nom"] . "</option> ";
	    }
	    
	     echo "</select></tr></td>";
	}    	
}

// prints the small images to the left of the big one when showing an article
function miniatureImage($what){
	$photoVariations=getVariationFctNom($what['ID']);
	$photoArticle=explode(";", $what['photo']);
	$img = $photoArticle[0];
	$currId = 0;
	$testVideo=0;

	echo "<table>";
			
	foreach($photoArticle as $i)
	{
		echo"<tr>
				<td>
				<a href='#'><img id='imgNo$currId' src='".$i."' width='50' height='50' style='float : left,'/></a>
				</td></tr>";		
		$currId++;		
	}


	foreach ($photoVariations as $nomvari => $i) 
	{
		foreach ($i as $varindividuelle) 
		{
			if($varindividuelle['photo']!=null)
			{
				echo "<tr>
					<td>
					<a href='#'><img id='imgNo$currId' src='".$varindividuelle['photo']."' width='50' height='50' style='float : left,'/></a>
					</td>
					</tr>";
				$currId++;
			}
		}			
	}
/*<video width='50' height='50' controls='controls'>
						<source src='".$what["video"]."' type='video/mp4' />
					</video>*/
	if($what["video"]!=null)
	{
		$testVideo=1;
		echo "<tr>
				<td>
				<a href='#'>
					<p id='vidNo'>Video</p>
				</a>
				</td>
				</tr>";		
	}

	else
		$testVideo=0;

	echo "		
	</table>";
	$nbImage=$currId;
	?>

	<script type="text/javascript">
		$(document).ready(function(){
			for(let i=0; i< <?= $nbImage ?>; i++){
				$("#imgNo" + i).click(function(event){
					$("#imagePrincipale").attr("src", $(event.target).attr("src"));
					//test.getElementById("#imagePrincipale").style.display = "none";
					$("#imagePrincipale").css("display", "block");
					$("#articleVideo").css("display", "none");
				});
			}

				$("#vidNo").click(function(event){
					$("#imagePrincipale").css("display", "none");
					$("#articleVideo").css("display", "block");
				});
			

		});
			
	</script>
	<?php
}

//affiche un seul article sur la page
function showSingleArticle($what){

//remplir un tableau des variation ayant le artice_id=$what['ID']
	$variations = getVariationFctType($what['ID']);
	$taille = 5;
	$photoArticle=explode(";", $what['photo']);
	$imge=$photoArticle[0];
	$video = $what["video"];


echo "	<table class='articleUniqueTab'>
		  <tr>
		    <td rowspan='".$taille."'>";
			miniatureImage($what);
			echo"</td>
		    <td class='singleImage' rowspan='".$taille."' >
		    	<img id='imagePrincipale' width='300' height='300' style='display: block' src='".$imge."' />
				<iframe id='articleVideo' width='300' height='300' style='display: none' src='https://www.youtube.com/embed/".$video."'></iframe>
		    	
		    </td>
		    <th class='singleArticle'>".$what["nom"]."</th>
		    <td rowspan='".$taille."'> 
		    	<table>";
		    		repeatVariation($variations);
		    echo"</table>
		    </td>		
		  </tr>
		  <tr>
		  	<td class='singleArticle'>Quantité restante : " . $what['quantite']."</td>";
		  	echo "
		  </tr>
		  <tr>
		  	<td class='singleArticle'>prix :" . $what["prix"] . "€</td>
		  			  </tr>
		  <tr>
		  	<td class='singleArticle'>".$what["note"]."/5</td>
		  </tr>
		  <tr>
		  	<td class='singleArticle'>".$what["description"]."</td>
		  </tr>		 
		</table> ";

echo "<table>
		<tr>
			<td>(Il reste ".$what["quantite"]." artticle(s))<br>Je commande : ";
			addToShopcartForm($what);
			echo "<td/>
			<td rowspan='2' style='    padding-left: 10%;
    width: 50%;'>mettez votre note sur 5<td/>
		</tr>
	  </table>";


echo "<br><br><br>";

echo "</div>";
}
?>
