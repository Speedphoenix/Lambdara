<?php
function showArticle($what)
{
	global $currShopcart;

	echo "<div class='article' id='" . $what["ID"] . "'>";
echo "pour l'instant vide
<form method='post' action=" . $_SERVER['PHP_SELF'] .">
<input type='number' name='addAmount' min='0'";

if (isset($currShopcart[$what["ID"]]))
	echo "value='" . $currShopcart[$what["ID"]] . "'";

echo "/>
<input type='hidden' name='addShopcart' value='" . $what["ID"] . "'>
<input type='submit' value='Add to cart'/>
</form>";

	echo "</div>";
}

?>
