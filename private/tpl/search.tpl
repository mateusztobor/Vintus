<div class="form-floating mb-3">
	<input type="text" class="form-control" id="search_text" placeholder="Czego szukasz?" onchange="reloadSearch();">
	<label for="search_text">Czego szukasz?</label>
	
	<div class="mt-3">
		<div class="dropdown">
			<?php
				$filter_colors = [
					//[ID,NAZWA],
					[1,'Czarny'],
					[9,'Niebieski'],
				];
			?>
			<a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Kolor
			</a>
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

<div id="search"></div>
<div class="text-center alert bg-body-secondary h3 fw-normal" id="search_loading">
	<div class="spinner-border" style="width: 3rem;height: 3rem;" role="status">
		<span class="visually-hidden">Wczytywanie...</span>
	</div>
</div>

<script>
	var search_url = '<?php print(Flight::getConfig('url')); ?>/search?';
</script>
<script src="<?php print(Flight::getConfig('url')); ?>/public/js/search.js"></script>