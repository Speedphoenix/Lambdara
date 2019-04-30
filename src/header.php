<?php
include_once "config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style.css">
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
	<?php
	echo "<title>";
	if (isset($pageTitle))
		echo "$pageTitle - ";
	echo SITENAME . "</title>";
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
          <a id="login-link" href="login.php#login"><button>Sign In</button></a>
          <a id="register-link" href="login.php#register"><button>Sign Up</button></a>
        </div>
    </div>
