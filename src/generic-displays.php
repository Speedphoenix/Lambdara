<?php

include_once "config.php";

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
		echo "value='" . $currShopcart[$what["ID"]] . "'/>
		<input type='hidden' name='addShopcart' value='" . $what["ID"] . "'>
		<input type='submit' value='Add to cart'/>
	</form>";
}


function showSingleArticle($what){
echo "	<table class='articleUnique'>

		  <tr>
		    <td rowspan='2'><img src='".$what["photo"]."'width='400' height='400' style='float : left,  border: 1px solid black;'/></td>
		    <th class='articleDetail'>".$what["nom"]."</th>
		    <td class='articleDetail'>prix : ".$what["prix"]."$</td>
		    <td class='articleDetail'>note :".$what["note"]."/5</td>

		    <td class='articleDetail'>Quantité restante : " . $what['quantite'];
			addToShopcartForm($what);
			echo"</td>
		  </tr>

		  <tr>
		  	<td colspan='4'>".$what["description"]."</td>
		  </tr>
		 
		</table> ";
echo "</div>";
}
?>
