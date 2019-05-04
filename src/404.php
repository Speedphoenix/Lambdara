<?php

include_once "config.php";
include_once "dbFuncs.php";
include_once "shopcart-general.php";
include_once "generic-displays.php";

$pageTitle = "404 not found";

include "header.php";
?>

<div>
<?php showError(Error 404) ?>
</div>

<?php
include "footer.php";
?>
