<div class="form-floating mb-3">
	<input type="text" class="form-control" id="search_text" placeholder="Czego szukasz?" onchange="reloadSearch();">
	<label for="search_text">Czego szukasz?</label>
	
	<div class="mt-3">
		<div class="dropdown">
			<a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Kolor
			</a>
			<?php
				$filter_colors = [
					//[ID,NAZWA],
					[1,'Czarny'],
					[2,'Brązowy'],
					[3,'Szary'],
					[4,'Beżowy'],
					[5,'Różowy'],
					[6,'Fioletowy'],
					[7,'Czerwony'],
					[8,'Żółty'],
					[9,'Niebieski'],
					[10,'Zielony'],
					[11,'Pomarańczowy'],
					[12,'Biały'],
					[13,'Srebny'],
					[14,'Złoty'],
					[15,'Wielokolorowe'],
					[16,'Khaki'],
					[17,'Turkusowy'],
					//[18,''],
					//[19,''],
					[20,'Kremowy'],
					[21,'Morelowy'],
					[22,'Koralowy'],
					[23,'Burgundowy'],
					[24,'Róż'],
					[25,'Liliowy'],
					[26,'Jasny Niebieski'],
					[27,'Granatowy'],
					[28,'Ciemny Zielony'],
					[29,'Musztardowy'],
					[30,'Miętowy']

				];
	$filter_materials = [
							//[ID,NAZWA],
							[1,'Ceramika'],
							[2,'Bawełna'],
							[3,'Szkło'],
							[4,'Metal'],
							[5,'Plastik'],
							[6,'Poliester'],
							[7,'Porcelana'],
							[8,'Drewno'],
							[9,'Srebro'],
							[10,'Stal'],
							[11,'Akryl'],
							[12,'Bambus'],
							[13,'Szyfon'],
							[14,'Len'],
							[15,'Nylon'],
							[16,'Satyna'],
							[17,'Jedwab'],
							[18,'Wiskoza'],
							[19,'Wełna'],
							[20,'Inne']
			?>
			<ul class="dropdown-menu">
				<?php foreach($filter_colors as $filter) { ?>
					<li class="py-2 px-1">
						<div class="form-check d-block">
							<label class="d-block" for="color_<?php print($filter[0]); ?>">
								<input class="form-check-input filter_colors" type="checkbox" value="<?php print($filter[0]); ?>" id="color_<?php print($filter[0]); ?>" onchange="reloadSearch();">
								<?php print($filter[1]); ?>
							</label>
						</div>
					</li>
				<?php } ?>
			</ul>
			<ul class="dropdown-menu">
				<?php foreach($filter_materials as $material) { ?>
					<li class="py-2 px-1">
						<div class="form-check d-block">
							<label class="d-block" for="material_<?php print($fmaterial[0]); ?>">
								<input class="form-check-input filter_materials" type="checkbox" value="<?php print($material[0]); ?>" id="material_<?php print($material[0]); ?>" onchange="reloadSearch();">
								<?php print($material[1]); ?>
							</label>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	
	<div class="mt-3">
		<div class="row">
			<div class="col-6">
				<div class="input-group mb-3">
					<span class="input-group-text">Cena od:</span>
					<input type="number" class="form-control" id="price_from" value="" min="0.00" step="0.01" onchange="reloadSearch();">
				</div>
			</div>
			<div class="col-6">
				<div class="input-group mb-3">
					<span class="input-group-text">Cena do:</span>
					<input type="number" class="form-control" id="price_to" value="" step="0.01" onchange="reloadSearch();">
				</div>
			</div>
		</div>
	</div>
	
	<div class="mt-3">
		<div class="form-floating">
			<select class="form-select" id="order" onchange="reloadSearch();">
				<option value="fav">Liczba ulubionych (malejąco)</option>
				<option value="unfav">Liczba ulubionych (rosnąco)</option>
				<option value="relevance">Trafność</option>
				<option value="price_high_to_low">Cena (malejąco)</option>
				<option value="price_low_to_high">Cena (rosnąco)</option>
				<option value="newest_first">Ostatnio dodane</option>
			</select>
			<label for="order">Sortuj według</label>
		</div>
	</div>
	<!--
	<div class="d-grid mt-3">
		<button type="button" class="btn btn-outline-success btn-lg" onclick="reloadSearch();">Wyszukaj</button>
	</div>
	-->
</div>
<div id="zac" class="row d-flex align-items-center my-4">
	<div class="col-md-6">
		<img src="<?php print(Flight::getConfig('url')); ?>/public/img/vinter.jpg" class="w-100 rounded-circle box-shadow" alt="">
	</div>
	<div class="col-md-6 text-center" style="font-family: Garamond, serif;">
		<div class="display-4">
			Bądź <span class="fw-bold" style="color: #007782;">COOL</span> dzięki<br>
			<img src="<?php print(Flight::getConfig('url')); ?>/public/img/logo.png" alt="Vintuś" style="height:64px;">
		</div>
		<div class="h4 text-primary mt-4">Twórz własne kreacje i dziel się nimi!</div>
	</div>
</div>
<div class="modal fade modal-lg" id="itemModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Dodawane przedmiotu do kreacji</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" value="" id="item_id">
				<label for="baskets" class="form-label">Wybierz kreację do której dodać przedmiot</label>
				<?php if(count($baskets) == 0) { ?>
					<div class="alert alert-warning">Wygląda na to, że nie utworzyłeś jeszcze żadnej kreacji.</div>
				<?php } else { ?>
					<select class="form-select" id="basket_id" data-choice="select-one">
						<option value="">Wybierz kreację</option>
						<?php foreach($baskets as $basket) { ?>
							<option value="<?php print($basket['basket_id']); ?>"><?php print($basket['name']); ?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<div class="btn-group w-100">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Anuluj</button> 
					<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="addItem();"><i class="fa-solid fa-plus"></i> Dodaj przedmiot do kreacji</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="search"></div>
<div class="text-center alert bg-body-secondary h3 fw-normal d-none" id="search_loading">
	<div class="spinner-border" style="width: 3rem;height: 3rem;" role="status">
		<span class="visually-hidden">Wczytywanie...</span>
	</div>
</div>

<script>
	var search_url = '<?php print(Flight::getConfig('url')); ?>/search?';
	function setItem(a) {
		document.getElementById("item_id").value = a;
	}
	function addItem() {
		var item_id = document.getElementById('item_id').value;
		var basket_id = document.getElementById('basket_id').value;
		var formData = new FormData();
		formData.append('basket_id', basket_id);
		formData.append('item_id', item_id);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php print(Flight::getConfig('url')); ?>/ajax/addItem', true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					try {
						var response = JSON.parse(xhr.responseText);
						if (!response.success)
							alert('Błąd systemu.');
					} catch (error) {
						alert('Błąd systemu.');
					}
				} else
					alert('Błąd systemu.');
			}
		};
		xhr.send(formData);
	}
	//var group = document.getElementById('post_group').value;
</script>
<script src="<?php print(Flight::getConfig('url')); ?>/public/js/search.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
<script> 
	const element = document.getElementById('basket_id');
	const choices = new Choices(element);
</script>
