<div class="px-lg-5 mx-lg-5">
	<div class="px-lg-5 mx-xl-5">
		<div class="px-xl-5 mx-lg-5">
			<div id="search"></div>
			<div class="text-center alert bg-body-secondary h3 fw-normal" id="search_loading">
				<div class="spinner-border" style="width: 3rem;height: 3rem;" role="status">
					<span class="visually-hidden">Wczytywanie...</span>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var search_url = '<?php print(Flight::getConfig('url')); ?>/search?search_text=buty';
</script>
<script src="<?php print(Flight::getConfig('url')); ?>/public/js/search.js"></script>