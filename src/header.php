<?php
include_once "config.php";

if (session_status() == PHP_SESSION_NONE)
	session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
	<link rel="manifest" href="site.webmanifest">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 
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
            <a href="category.php"><button>Accueil</button></a>
            <?php
                if (!empty($_SESSION['username']))
                {
                    if(USERSTATUSES[getUserInfo($_SESSION['username'], 'statut')] === 'seller')
                    {
                        echo"<a href='sell.php'><button>Vendre</button></a>";
                    }
                }
            ?>
			<a href="shopcart.php"><button>Panier
				<?php
					if (isset($nbShopcart))
						echo "(".$nbShopcart.")";
				?>
			</button></a>
			<?php
			if (empty($_SESSION['username']))
			{
				echo '
				<a id="login-link" href="login.php#login"><button>Connection</button></a>
				<a id="register-link" href="login.php#register"><button>S\'enregistrer</button></a>';
			}
			else
			{
				echo '<a id="logout-link" href="logout.php?previouspage=' . $_SERVER['PHP_SELF'] . '"><button>Deconnection</button></a>';
				switch (USERSTATUSES[getUserInfo($_SESSION['username'], 'statut')])
				{
					default:
					case 'buyer':
						$targeturl = "user-page.php";
						$message = "Ma page";
						break;
					case 'seller':
						$targeturl = "seller.php";
						$message = "Ma page";
						break;
					case 'admin':
						$targeturl = "admin.php";
						$message = "admin";
						break;
				}
				echo "<a id='userpage-link' href='$targeturl'><button>" . $_SESSION['username'] . " - $message</button></a>";
			}
			?>
		</div>
	</div>
