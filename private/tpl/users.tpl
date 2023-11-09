<h1 class="mb-4 fw-normal">Konta <?php print($manager ? 'zarządców' : 'najemców'); ?></h1>
<div class="my-4 d-grid d-xl-block text-end">
	<a href="<?php print(Flight::getConfig('url').$app_path); ?>/dodaj" class="btn btn-dark bg-gradient"><i class="fa-solid fa-plus"></i> Stwórz konto <?php print($manager==1 ? 'zarządcy' : 'najemcy'); ?></a>
</div>
<!--tuto -->
<div style="overflow-x: auto;">
	<table class="table table-bordered table-striped" id="users">
		<thead>
			<tr>
				<th scope="col" class="col-auto align-middle">Imię i nazwisko</th>
				<?php if(!$manager) { ?>
					<th scope="col" class="col-2 align-middle text-center">Umowa najmu</th>
					<th scope="col" class="col-1 align-middle text-center">Kompensacja (bieżące saldo)</th>
					<th scope="col" class="col-2 align-middle text-center">Bieżące saldo</th>
				<?php } ?>
				<th scope="col" class="col-3 align-middle text-center">Kontakt</th>
				<th scope="col" class="col-1 align-middle text-center">Opcje</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($users as $user) { ?>
				<tr>
					<td class="align-middle">
						<?php print($user['first_name'].' '.$user['second_name']); ?>
					</td>
					<?php if(!$manager) { ?>
						<td class="align-middle text-center"><?php print($user['agreement']); ?></td>
						<td class="align-middle text-center"><?php print($user['compensation'] ? 'Tak' : 'Nie'); ?></td>
						<td class="align-middle text-center"><?php print($user['results']); ?></td>
					<?php } ?>
					<td class="align-middle text-center">
						<div class="d-grid gap-2">
							<a href="tel:+<?php print($user['phone_number']); ?>" class="btn btn-light btn-sm" role="button"><i class="fa-solid fa-phone"></i> +<?php print(Flight::formatPhoneNumber($user['phone_number'])); ?></a>
							<a href="mailto:<?php print($user['email']); ?>" class="btn btn-light btn-sm" role="button"><i class="fa-regular fa-envelope"></i> <?php print($user['email']); ?></a>
						</div>
					</td>
					
					<td class="align-middle text-center">
						<div class="btn-group me-2">
							<?php if(!$manager) { ?>
								<a class="btn btn-outline-secondary" href="<?php print(Flight::getConfig('url')); ?>/najemcy/<?php print($user['user_id']); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profil najemcy"><i class="fa-solid fa-id-card"></i></a>
							<?php } ?>
							<a class="btn btn-outline-secondary" href="<?php print(Flight::getConfig('url').$app_path.'/edytuj/'.$user['user_id']); ?>"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edytuj dane"><i class="fa-solid fa-pen-to-square"></i></a>
						</div>
					</td>
				</tr>
			<?php } ?>
	  </tbody>
	</table>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/pl.json"></script>
<script>
	let table = new DataTable('#users', {
		language: {
			url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pl.json'
		},
        "columns": [
            { "data": "uzytkownik" },
            <?php if(!$manager) { ?>
				{ "data": "kompensacja" },
				{ "data": "umowa" },
				{ "data": "saldo" },
			<?php } ?>
            { "data": "kontakt", "orderable" : false },
            { "data": "opcje", "orderable": false },
        ],
		"searching": true,
		"pageLength": 10,
		"lengthMenu": [  ],
		"bLengthChange": false,
		"order": [[ 0, 'asc' ]]
	});
	table.draw();
</script>
<div class="py-4"></div>
