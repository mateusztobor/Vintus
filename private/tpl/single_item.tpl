<?php if(isset($item)) { ?>
		<div class="row rounded mb-4 text-dark" style="background: #cae1e4;">
			<div class="col-12 col-md-4 p-0 d-flex align-items-center justify-content-center position-relative">
				<?php
					$in_card=false;
					$photo = Flight::getConfig('url').'/public/img/vinter.jpg';
					if(isset($item['photo']['url']))
						$photo = $item['photo']['url'];
					elseif(isset($item['photos'])) {
						$in_card=true;
						foreach($item['photos'] as $ph) {
							if($ph['is_main'] == 1)
								$photo=$ph['url'];
						}
					}	
				?>
				<img src="<?php print($photo); ?>" alt="" class="img-fluid rounded">
			</div>
			<div class="col-12 col-md-8 text-center d-flex align-items-center justify-content-center">
				<div class="pt-3 pb-3 pe-3">
					<h2 class="text-transform-none fw-bold"><?php print($item['title']); ?></h2>
					<div style="display: flex; justify-content: center;"><div class="h6 text-transform-none" style="text-align: left">
						<i class="fa-solid fa-heart"></i> <?php print($item['favourite_count']); ?>
						
						<?php if(isset($item['size_title']) && $item['size_title'] !== "") { ?>
							<br /><i class="fa-solid fa-maximize"></i> <?php print($item['size_title']); ?>
						<?php } ?>
						
						<?php if(isset($item['brand_title']) && $item['brand_title'] !== "") { ?>
							<br /><span class="d-block d-md-inline text-transform-none"><i class="fa-solid fa-award"></i> <?php print($item['brand_title']); ?></span>
						<?php } ?>
					</div></div>
					<div class="h6 text-transform-none">
						Możliwa wymiana: <?php print(empty($item['is_for_swap']) ? 'Nie' : 'Tak');?><br />
						<?php print(empty($item['user']['business']) ? 'Osoba prywatna' : 'Firma'); ?> 
					</div>
					<div class="h5"><i class="fa-solid fa-money-bill-wave"></i> <?php print(Flight::formatCurrency($item['total_item_price'], $item['currency'])); ?></div>
					<div class="h6 fw-normal">w tym <?php print(Flight::formatCurrency($item['service_fee'], $item['currency'])); ?> opłaty serwisowej</div>
					<div class="mt-4">
						<?php if(Flight::isAuthorized('logged') && !$in_card) { ?>
							<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#itemModal" onclick="setItem(<?php print($item['id']); ?>);"><i class="fa-solid fa-shirt"></i> Dodaj do kreacji</button>
						<?php } ?>
						<?php if($in_card) { ?>
							<?php if(isset($isOwner)) { ?>
								<?php if($isOwner) { ?>
									<button type="button" class="btn btn-outline-danger" onclick="deleteItem(<?php print($item_id); ?>);"><i class="fa-solid fa-xmark"></i> Usun z kreacji</button>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<a href="<?php print($item['url']); ?>" target="_blank" class="btn btn-dark bg-gradient"><i class="fa-solid fa-shop"></i> Przejdź do oferty</a>
					</div>
				</div>
			</div>
		</div>
<?php } ?>