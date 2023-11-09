<?php if(isset($item)) { ?>
		<div class="row rounded mb-4 text-dark" style="background: #96f0fb;">
			<div class="col-12 col-md-4 p-0 d-flex align-items-center justify-content-center position-relative">
				<img src="<?php print($item['photo']['url']); ?>" alt="Zdjęcie mieszkania" class="img-fluid rounded">
			</div>
			<div class="col-12 col-md-8 text-center d-flex align-items-center justify-content-center">
				<div class="pt-3 pb-3 pe-3">
					<h2 class="text-transform-none fw-bold"><?php print($item['title']); ?></h2>
					<div class="h6 text-transform-none">
						<i class="fa-solid fa-heart"></i> <?php print($item['favourite_count']); ?>
						<i class="fa-solid fa-maximize ms-3"></i> <?php print($item['size_title']); ?>
						<span class="d-block d-md-inline text-transform-none">
						<i class="fa-solid fa-award ms-3"></i> item.brand</span>
					</div>
					<div class="h6 text-transform-none">
						Możliwa wymiana: <?php print(empty($item['is_for_swap']) ? 'Nie' : 'Tak'); ?> 
						<?php print(empty($item['user']['business']) ? 'Osoba prywatna' : 'Firma'); ?> 
					</div>
					<div class="h5"><i class="fa-solid fa-money-bill-wave"></i> <?php print(Flight::formatCurrency($item['price'], $item['currency'])); ?></div>
					<div class="mt-4">
						<button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-heart"></i> Dodaj do ulubionych</button>
						<a href="<?php print($item['url']); ?>" target="_blank" class="btn btn-dark bg-gradient"><i class="fa-solid fa-shop"></i> Przejdź do oferty</a>
					</div>
				</div>
			</div>
		</div>
<?php } ?>