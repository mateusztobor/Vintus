<h1 class="fw-normal">Logowanie</h1>
<div class="alert alert-light mt-4 d-none" id="installApp_prompt">
	<div class="text-center fw-bold mb-2">
		Zainstaluj naszą aplikację, by mieszkać jeszcze wygodniej!
	</div>
	<div class="d-grid">
		<button id="installApp_btn" class="btn btn-lg btn-outline-success"><i class="fa-solid fa-cloud-arrow-down"></i> Zainstaluj teraz</button>
	</div>
</div>
<h2 class="h4 fw-normal mt-4">Wybierz sposób logowania:</h2>
<nav class="mt-4 mb-0">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="login-phone-tab" data-bs-toggle="tab" data-bs-target="#login-phone" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Numer telefonu</button>
    <button class="nav-link" id="login-email-tab" data-bs-toggle="tab" data-bs-target="#login-email" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Adres email</button>
  </div>
</nav>
<div class="tab-content border-start border-end border-bottom p-4" id="nav-tabContent">
	<div class="tab-pane fade show active" id="login-phone" role="tabpanel" aria-labelledby="login-phone-tab" tabindex="0">
		<h3 class="h5 fw-normal mb-4">Logowanie przez numer telefonu</h3>
		<form method="post" action="<?php echo Flight::getConfig('url'); ?>/logowanie">
			<div class="row mb-4">
				<div class="col-4 me-0 pe-0">
					<select class="form-select form-select-lg" name="login_code">
						<option value="48">+48 (Polska)</option>
						<option value="380">+380 (Ukraina)</option>
						<option value="49">+49 (Niemcy)</option>
						<option value="420">+420 (Czechy)</option>
						<option value="421">+421 (Słowacja)</option>
						<option value="375">+375 (Białoruś)</option>
						<option value="370">+370 (Litwa)</option>
						<option value="371">+371 (Łotwa)</option>
						<option value="7">+7 (Rosja)</option>
						<option value="46">+46 (Szwecja)</option>
						<option value="45">+45 (Dania)</option>
					</select>
				</div>
				<div class="col-8 ms-0 ps-0">
					<input type="tel" pattern="[0-9]{7,12}" title="Numer telefonu bez kierunkowego. 7-12 cyfr." name="login_phone" class="form-control form-control-lg" id="login_phone" placeholder="Numer telefonu" autocomplete="tel" required>
				</div>
			</div>
			<div class="form-floating mb-4">
				<input type="password" name="login_password" class="form-control" id="login_password" placeholder="Hasło" autocomplete="current-password" required>
				<label for="login_password">Hasło</label>
			</div>
			<button class="w-100 btn btn-md btn-light btn-login" type="submit" name="do_login"><i class="fa-solid fa-right-to-bracket"></i> Zaloguj</button>
		</form>
	</div>
	<div class="tab-pane fade" id="login-email" role="tabpanel" aria-labelledby="login-email-tab" tabindex="0">
		<h3 class="h5 fw-normal mb-4">Logowanie przez adres email</h3>
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
	</div>
</div>
<script>
let installPromptEvent; // Definiujemy zmienną w zakresie globalnym

window.addEventListener('beforeinstallprompt', (event) => {
  installPromptEvent = event; // Przypisujemy zdarzenie do zmiennej w obszarze słuchacza
  event.preventDefault();
  showInstallButton();
});

function showInstallButton() {
  document.getElementById('installApp_prompt').classList.remove("d-none");
  document.getElementById('installApp_btn').addEventListener('click', () => {
    if (installPromptEvent) {
      installPromptEvent.prompt();
    }
  });
}
</script>
