<h1 class="fw-normal mb-4"><?php print(isset($user) ? 'Edycja' : 'Tworzenie'); ?> konta <?php print($manager ? 'zarządcy' : 'najemcy'); ?></h1>
<form method="post" class="needs-validation" novalidate>
	<div class="mb-4">
		<label for="first_name" class="form-label">Imię</label>
		<input type="text" value="<?php print(isset($user['first_name']) ? $user['first_name'] : (isset(Flight::request()->data->first_name) ? Flight::request()->data->first_name : '')); ?>" class="form-control" id="first_name" placeholder="Wprowadź imię użytkownika" maxlength="64" name="first_name" required>
		<div class="invalid-feedback">
			Maksymalna ilość znaków to 64. To pole jest wymagane.
		</div>
	</div>
	<div class="mb-4">
		<label for="second_name" class="form-label">Nazwisko</label>
		<input type="text" value="<?php print(isset($user['second_name']) ? $user['second_name'] : (isset(Flight::request()->data->second_name) ? Flight::request()->data->second_name : '')); ?>" class="form-control" id="second_name" placeholder="Wprowadź nazwisko użytkownika" maxlength="64" name="second_name" required>
		<div class="invalid-feedback">
			Maksymalna ilość znaków to 64. To pole jest wymagane.
		</div>
	</div>
	<div class="mb-4">
		<label for="email" class="form-label">Adres email</label>
		<input type="email" value="<?php print(isset($user['email']) ? $user['email'] : (isset(Flight::request()->data->email) ? Flight::request()->data->email : '')); ?>" class="form-control" id="email" placeholder="Wprowadź adres email" maxlength="255" name="email" required>
		<div class="invalid-feedback">
			Wprowadź poprawny adres email. Maksymalna długość to 255. To pole jest wymagane.
		</div>
	</div>
	<div class="mb-4">
		<label for="phone_number" class="form-label">Numer telefonu</label>
		<input type="text" value="<?php print(isset($user['phone_number']) ? $user['phone_number'] : (isset(Flight::request()->data->phone_number) ? Flight::request()->data->phone_number : '')); ?>" pattern="[0-9]{11,15}" maxlenght="15" title="Wprowadź numer telefonu z numerem kierunkowym (bez znaku +)" name="phone_number" class="form-control" id="phone_number" placeholder="Wprowadź numer telefonu z numerem kierunkowym (bez znaku +)" required>
		<div class="invalid-feedback">
			Wprowadź numer telefonu z numerem kierunkowym (bez znaku +). To pole jest wymagane.
		</div>
	</div>
	<div class="mb-4">
		<?php if(isset($user)) { ?>
			<div class="modal fade modal-dialog-scrollable modal-lg" data-bs-backdrop="static" id="confirm-del" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Potwierdzenie usunięcia użytkownika</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
						</div>
						<div class="modal-body">
							Czy na pewno chcesz usunąć tego użytkownika z systemu?<br>
							Spowoduje to usunięcie wszystkich jego umów najmu (aktywnych i zarchiwizowanych) oraz historii płatności.<br>
							Tej operacji nie można będzie cofnąć.
						</div>
						<div class="modal-footer">
							<a href="<?php print(Flight::getConfig('url').$app_path.'/usun/'.$id); ?>" rel="button" class="btn btn-success"><i class="fa-solid fa-trash-can"></i> Usuń</a>
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Anuluj</button>
						</div>
					</div>
				</div>
			</div>
			<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-del"><i class="fa-regular fa-trash-can"></i> Usuń użytkownika</button>
		<?php } ?>
		<button type="submit" name="save_post" class="btn btn-success"><?php print(isset($user) ? '<i class="fa-regular fa-square-check"></i> Zapisz zmiany' : '<i class="fa-solid fa-plus"></i> Stwórz konto'); ?></button>
	</div>
</form>
