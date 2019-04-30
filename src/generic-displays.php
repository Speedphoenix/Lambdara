<?php
function showArticle($what)
{

	echo "<div class='article' id='" . $what["ID"] . "'>";
echo  "".$what["nom"] . PHP_EOL . $what["prix"]."
<form method='post' action=" . $_SERVER['PHP_SELF'] .">
<input type='number' name='addAmount' min='0'";


echo "/>
<input type='hidden' name='addShopcart' value='" . $what["ID"] . "'>
<input type='submit' value='Add to cart'/>
</form>";

	echo "</div>";
}

?>
