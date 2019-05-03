<?php

include_once "config.php";
include_once "genericFuncs.php";




//Affiche un tableau d'articles

function showError($errmsg)
{
	echo "<h2 class='error'>$errmsg</h2>" . PHP_EOL;
}


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
echo "	<table class='articleUnique'>

		  <tr>
		    <td rowspan='2'><a href='singleArticle.php?ID=" . $what['ID'] . "'><img src='".$what["photo"]."'width='100' height='100' style='float : left'/></a></td>
		    <th class='articleDetail'><a href='singleArticle.php?ID=" . $what['ID'] . "' >".$what["nom"]."</a></th>
		    <td class='articleDetail'>prix : ".$what["prix"]."$</td>
		    <td class='articleDetail'>note :".$what["note"]."/5</td>
		    <td class='articleDetail'>Quantité restante : ".$what['quantite']."</td>
		  </tr>

		  <tr>
		  	<td colspan='4'>".$what["description"]."</td>
		  </tr>
		</table> ";
echo "</div>";
}

function addToShopcartForm($what)
{
	global $currShopcart;
	echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . makeGetUrl() . "'>
		<input type='number' name='addAmount' min='0'";

	if (isset($currShopcart[$what["ID"]]))
		echo "value='" . $currShopcart[$what["ID"]] . "'";
		
		echo "/>
		<input type='hidden' name='addShopcart' value='" . $what["ID"] . "'>
		<input type='submit' value='Add to cart'/>
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

//affiche un seul article
function showSingleArticle($what){

//remplir un tableau des variation ayant le artice_id=$what['ID']
	$variations = getVariation($what['ID']);
	$taille = 5;


echo "	<table class='articleUniqueTab'>

		  <tr>
		    <td class='singleImage' rowspan='".$taille."' ><img src='".$what["photo"]."'width='300' height='300' style='float : left,'/></td>
		    <th class='singleArticle'>".$what["nom"]."</th>
		    <td rowspan='".$taille."'> 
		    	<table>";
		    		repeatVariation($variations);
		    echo"</table>
		    </td>		
		  </tr>
		  <tr>
		  	<td class='singleArticle'>Quantité restante : " . $what['quantite']."</td>";
		  	echo "<td>  </td>
		  </tr>
		  <tr>
		  	<td class='singleArticle'>prix :".$what["prix"]."</td>
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
			<td rowspan='2'>mettez votre note sur 5<td/>
		</tr>
	  </table>";


echo "<br><br><br>";

echo "</div>";
}
?>
