<?php

include_once "config.php";
include_once "genericFuncs.php";

function showError($errmsg)
{
	echo "<h2 style='color: red;text-align: center;'>$errmsg</h2>" . PHP_EOL;
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


function showSingleArticle($what){
echo "	<table class='articleUnique'>

		  <tr>
		    <td rowspan='2'><img src='".$what["photo"]."'width='500' height='500' style='float : left'/></td>
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
