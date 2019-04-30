<?php
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

	<div id='register'>
		<button id="register-btn">Créez un compte</button>
		<form id='register-form' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
			<input type='hidden' name='formtype' value='register'/>
			<table>
				<tr>
					<td>Nom d'utilisateur:</td>
					<td><input type='text' name='username'></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type='text' name='email'></td>
				</tr>
				<tr>
					<td>Mot de passe:</td>
					<td><input type='password' id='registerpass' name='password'></td>
				</tr>
				<tr>
					<td>Confirmer le mot de passe:</td>
					<td><input type='password' id='confirmpass' name='confirm-password'></td>
				</tr>
				<tr>
					<td colspan='2'><input type='submit' value="C'est parti!"></td>
				</tr>
			</table>
		</form>
	</div>

	<div id='login'>
		<button id="login-btn">Déjà utilisateur?</button>
		<form id='login-form' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
			<input type='hidden' name='formtype' value='login'/>
			<table>
				<tr>
					<td>Nom d'utilisateur ou email:</td>
					<td><input type='text' name='username'></td>
				</tr>
				<tr>
					<td>Mot de passe:</td>
					<td><input type='password' name='password'></td>
				</tr>
				<tr>
					<td colspan='2'><input type='submit' value="S'identifier"></td>
				</tr>
			</table>
		</form>
	</div>

</div>

<?php
include "footer.php";
?>
