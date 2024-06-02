
<form action="nuova_password.php" method="post" id="login">

	<div class="campo_contatti">
		<div class="voce_campo">* email</div>
		<input type="text" name="email" value="<?=@$_POST['email']?>" class="campo" <?php if(!$email || !$password) echo $errore; ?> />
	</div>
	
	<div class="campo_contatti">
		<div class="voce_campo">* password</div>
		<input type="password" name="password" value="" class="campo" <?php if(!$email || !$password) echo $errore; ?> />
	</div>
	
	<div class="clear"></div>
		
	<div class="campo_contatti">
		<input type="submit" value="Accedi" />
	</div>
	
	<div class="clear"></div>
	
	<div class="campo_contatti">
			Hai dimenticato la password? Clicca <a href="recupero.php?mode=pwd" style="color: red">qui</a>
	</div>
	
	<div class="clear"></div>

</form>
