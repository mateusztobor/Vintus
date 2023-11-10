<h1 class="fw-normal mb-4">Logowanie</h1>
<div class="alert alert-light mt-4 d-none" id="installApp_prompt">
	<div class="text-center fw-bold mb-2">
		Zainstaluj naszą aplikację i bądź jeszcze bardziej COOL!
	</div>
	<div class="d-grid">
		<button id="installApp_btn" class="btn btn-lg btn-outline-success"><i class="fa-solid fa-cloud-arrow-down"></i> Zainstaluj teraz</button>
	</div>
</div>
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
