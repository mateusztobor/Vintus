<h1 class="fw-normal mb-4">Logowanie</h1>
<form method="post" action="<?php echo Flight::getConfig('url'); ?>/logowanie">
	<div class="form-floating mb-4">
		<input type="email" name="login_email" class="form-control" id="login_email" placeholder="Adres email" autocomplete="email" required>
		<label for="login_email">Adres email</label>
	</div>
	<div class="form-floating mb-4">
		<input type="password" name="login_password" class="form-control" id="login_password2" placeholder="Hasło" autocomplete="current-password" required>
		<label for="login_password2">Hasło</label>
	</div>
	<button class="w-100 btn btn-md btn-light btn-login" type="submit" name="do_login"><i class="fa-solid fa-right-to-bracket"></i> Zaloguj</button>
</form>