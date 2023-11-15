<h1 class="fw-normal mb-4">Tworzenie nowego konta</h1>
<form method="post">
	<div class="col mb-4">
		<label for="nick" class="form-label">Twój nick</label>
		<input type="text" value="" class="form-control" id="nick" placeholder="Wprowadź Twój nick" maxlength="64" name="nick" required>
	</div>
	<div class="col mb-4">
		<label for="c_pass" class="form-label">Adres email</label>
		<input type="email" value="" class="form-control" id="email" placeholder="Wprowadź Twój adres email" maxlength="255" name="email" required>
	</div>
	<div class="col mb-4">
		<label for="password" class="form-label">Hasło</label>
		<input type="password" value="" class="form-control" id="password" placeholder="Wprowadź hasło do konta" maxlength="128" name="password" pattern="^(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$" title="Hasło musi mieć minimum 8 znaków i zawierać co najmniej 1 znak specjalny (!@#$%^&*)." required>
	</div>
	<div class="col mb-4">
		<label for="password2" class="form-label">Powtórz hasło</label>
		<input type="password" value="" class="form-control" id="password2" placeholder="Powtórz hasło" maxlength="128" name="password2" required>
	</div>
	<div class="mb-4">
		<button type="submit" name="createNewAccount" class="btn btn-success"><i class="fa-solid fa-plus"></i> Stwórz konto</button>
	</div>
</form>
