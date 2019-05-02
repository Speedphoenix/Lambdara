<?php

include_once "auth.php";
include_once "genericFuncs.php";
include_once "generic-displays.php";

setPrevPage();

if (!empty($_SESSION['username'])
	|| (isset($logSuccess) && ($logSuccess === true)))
{
	header("location: " . getPrevPage("category.php"));
}

$pageTitle = "Login";

include "header.php";
?>

<script type="text/javascript">
function showRegister() {
	$('#login-form').css('display', 'none');
	$('#register-form').css('display', 'block');
	$('#login-btn').css('display', 'block');
	$('#register-btn').css('display', 'none');
}

function showLogin() {
	$('#login-form').css('display', 'block');
	$('#register-form').css('display', 'none');
	$('#login-btn').css('display', 'none');
	$('#register-btn').css('display', 'block');
}

	$(document).ready(function(){
		if (window.location.hash && window.location.hash.substring(1) === 'login') {
			showLogin();
		}
		else{
			showRegister();
		}
		$('#login-btn').click(showLogin);
		$('#register-btn').click(showRegister);
		$('#login-link').click(showLogin);
		$('#register-link').click(showRegister);	
	});
</script>

<div id='mainContainer'>

<?php
	if (isset($_SESSION['username']))
		showError($_SESSION['username'] . "is already logged");
	if (!empty($errormsg))
		showError($errormsg);
?>

	<div id='register' class="clearfix">
        <div class="login">
            <button id="register-btn" class="log_btn">Créez un compte</button>
            <form id='register-form' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
                <input type='hidden' name='formtype' value='register' required/>
                <table class="log_tab"> 
                    <tr>
                        <!--<td>Nom complet:</td>-->
                        <td><input class="log_field" type='text' name='fullname' placeholder="Nom complet:" required></td>
                    </tr>
                    <tr>
                        <!--<td>Nom d'utilisateur:</td>-->
                        <td><input class="log_field" type='text' name='username' placeholder="Nom d'utilisateur:" required></td>
                    </tr>
                    <tr>
                        <!--<td>Email:</td>-->
                        <td><input class="log_field" type='email' name='email' placeholder="Email:" required></td>
                    </tr>
                    <tr>
                        <!--<td>Email:</td>-->
                        <td>
							<input type='radio' id='buyradio' name='userstatus' value='0' required checked>
							<label for='buyradio'>Acheteur</label></br>
							<input type='radio' id='sellradio' name='userstatus' value='1' required>
							<label for='sellradio'>Vendeur</label>
						</td>
                    </tr>
                    <tr>
                        <!--<td>Mot de passe:</td>-->
                        <td><input class="log_field" type='password' id='registerpass' name='password' placeholder="Mot de passe:" required></td>
                    </tr>
                    <tr>
                        <!--<td>Confirmer le mot de passe:</td>-->
                        <td><input class="log_field" type='password' id='confirmpass' name='confirm-password' placeholder="Confirmer le mot de passe:" required></td>
                    </tr>
                    <tr>
                        <td colspan='2'><input class="btn" type='submit' value="C'est parti!"></td>
                    </tr>
                </table>
            </form>
        </div>

	</div>

	<div id='login' class="clearfix">
        <div class="login">
            <button id="login-btn" class="log_btn">Déjà utilisateur?</button>
            <form id='login-form' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
                <input type='hidden' name='formtype' value='login' required/>
                <table class="log_tab">
                    <tr>
                        <!--<td>Nom d'utilisateur ou email:</td>-->
                        <td><input class="log_field" type='text' name='username' placeholder="Nom d'utilisateur ou email:" required></td>
                    </tr>
                    <tr>
                        <!--<td>Mot de passe:</td>-->
                        <td><input class="log_field" type='password' name='password' placeholder="Mot de passe" required></td>
                    </tr>
                    <tr>
                        <td colspan='2'><input class="btn" type='submit' value="S'identifier"></td>
                    </tr>
                </table>
            </form>
        </div>
	</div>

</div>

<?php
include "footer.php";
?>
