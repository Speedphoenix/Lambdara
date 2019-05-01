
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/query/3.1.1/jquery.min.js"></script>
	<script type="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<?php
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

echo "<div class='test' id='articles'>";
echo "	<table>

		  <tr>
		    <td rowspan='2'><img src='".$what["photo"]."'width='100' height='100'/></td>
		    <th>".$what["nom"]."</th>
		    <th>prix : ".$what["prix"]."$</th>
		    <th>note :".$what["note"]."/5</th>
		    <th>Quantité restante : ".$what['quantité']."</th>
		  </tr>

		  <tr>
		  	<td colspan='4'>".$what["description"]."</td>
		  </tr>
		 
		</table> ";





	echo "</div>";
}

?>
