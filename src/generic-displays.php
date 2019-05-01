<?php
function showArticle($what)
{

	echo "<div class='rightpart' id='articles'>";
echo  "<img src=".$what["photo"]."/></br>".$what["nom"]."</br>".$what["prix"]."";



	echo "</div>";
}

?>
