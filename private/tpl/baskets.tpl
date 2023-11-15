<li class="list-group-item py-3 border-bottom">
	<div class="input-group">
		<span class="input-group-text"><i class="fa-solid fa-person-half-dress me-2"></i> Tworzenie nowej kreacji</span>
		<input id="name" type="text" class="form-control" placeholder="Nazwa kreacji" maxlength="128">
		<button type="button" class="btn btn-success bg-gradient" onclick="createBasket();"><i class="fa-solid fa-plus"></i> Utwórz</button>
	</div>
</li>
<?php foreach($baskets as $basket) { ?>
	<li class="list-group-item py-3 border-bottom">
		<div class="row d-flex align-items-center">
			<div class="col-8">
				<strong><?php print($basket['name']); ?></strong><br>
				<small><i class="fa-solid fa-arrows-rotate"></i> Ostatnia aktualizacja: <?php print(Flight::formatDate($basket['lastmod'])); ?></small>
			</div>
			<div class="col-4 text-end">
				<div class="btn-group">
					<button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Usuń kreację" onclick="deleteMyBasket(<?php print($basket['basket_id']); ?>);"><i class="fa-solid fa-trash"></i></button>
					<a href="<?php print(Flight::getConfig('url')); ?>/kreacja/<?php print($basket['basket_id']); ?>" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Przejdź do kreacji" onclick="deleteAgreementFile();"><i class="fa-solid fa-angles-right"></i> Przejdź do kreacji</a>
				</div>
			</div>
		</div>
	</li>
<?php } ?>