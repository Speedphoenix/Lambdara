<?php
include_once "config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
	<?php
	if (isset($pageTitle))
		echo "<title>$pageTitle</title>";
	?>
</head>
<body>
	<div id="upperpart" class="clearfix">
        
        <div class="column menu">
          <a href="sell.php"><button>Vendre</button></a>
          <a href="shopcart.php"><button>Panier
              <?php
                    if (isset($nbShopcart))
                        echo "(".$nbShopcart.")";
                ?>
              
          </button></a>
          <a href="login.php#login"><button>Sign In</button></a>
          <a href="login.php#register"><button>Sign Up</button></a>
        </div>
        
        <div class="column search">
        <input class="field" name="q" type="text" placeholder="Rechercher" /><br>
        <input class="btn" type="submit" value="Rechercher" />
        </div>
        
    </div>
