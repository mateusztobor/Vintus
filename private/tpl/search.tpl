<div class="form-floating mb-3">
	<input type="text" class="form-control" id="search_text" placeholder="Czego szukasz?" onchange="reloadSearch();">
	<label for="search_text">Czego szukasz?</label>
	<div class="d-grid">
		<button type="button" class="btn btn-outline-success btn-lg" onclick="reloadSearch();">Wyszukaj</button>
	</div>
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