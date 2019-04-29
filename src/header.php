<?php
include_once "config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style.css">
	<?php
	if (isset($pageTitle))
		echo "<title>$pageTitle</title>";
	?>
</head>
<body>
	<div id="upperpart" class="clearfix">
        
        <div class="column menu">
          <a href="vendre.php"><button>Vendre</button></a>
          <a href="#panier.php"><button>Panier</button></a>
          <a href="#signin.php"><button>Sign In</button></a>
          <a href="#signup.php"><button>Sign Up</button></a>
        </div>
        
        <div class="column search">
        <input class="field" name="q" type="text" placeholder="Rechercher" /><br>
        <input class="btn" type="submit" value="Rechercher" />
        </div>
        
    </div>