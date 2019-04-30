<?php
function showArticle($what)
{

	echo "<div class='article' id='" . $what["ID"] . "'>";
echo  "<img src=".$what["photo"]."/></br>".$what["nom"]."</br>".$what["prix"]."";



	echo "</div>";
}

?>
