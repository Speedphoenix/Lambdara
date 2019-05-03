<?php

include_once "config.php";




//Affiche un tableau d'articles

function showError($errmsg)
{
	echo "<h2 style='color: red;text-align: center;'>$errormsg</h2>";
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
	echo "<form method='post' action=" . $_SERVER['PHP_SELF'] .">
		<input type='number' name='addAmount' min='0'";

	if (isset($currShopcart[$what["ID"]]))
		echo "value='" . $currShopcart[$what["ID"]] . "'";
		
		echo "/>
		<input type='hidden' name='addShopcart' value='" . $what["ID"] . "'>
		<input type='submit' value='Add to cart'/>
	</form>";
}



//affiche un seul article
//style='  border: 1px solid black', width: 2%>
function showSingleArticle($what){
echo "	<table class='articleUniqueTab'>

		  <tr>
		    <td class='sigleImage' rowspan='6' ><img src='".$what["photo"]."'width='300' height='300' style='float : left,'/></td>
		    <th class='singleArticle'>".$what["nom"]."</th>
			</td>
		  </tr>
		  <tr>
		  	<td class='singleArticle'>Quantité restante : " . $what['quantite']."
		  </tr>
		  <tr>
		  	<td class='singleArticle'>prix :".$what["prix"]."</td>
		  </tr>
		  <tr>
		  	<td>".$what["note"]."/5</td>
		  </tr>
		  <tr>
		  	<td class='singleArticle'>saisissez votre note sur 5</td>
		  </tr>
		  <tr>
		  	<td class='singleArticle'>".$what["description"]."</td>
		  </tr>		 
		</table> ";

echo "Quelle quantité désirez vous commander ?<br>";
		addToShopcartForm($what);

echo "<br><br><br>";

echo "</div>";
}
?>
