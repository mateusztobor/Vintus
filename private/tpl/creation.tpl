
<h1 class="fw-normal mb-0 h5">Kreacja</h1>
<h2 class="mb-4"><?php print($basket['name']); ?></h2>
<div class="fb-like" data-href="<?php print(Flight::getConfig('url')); ?>/kreacja/<?php print($basket['basket_id']); ?>" data-width="" data-layout="" data-action="" data-size="" data-share="false"></div><br>
<small><i class="fa-solid fa-arrows-rotate"></i> Ostatnia aktualizacja: <?php print(Flight::formatDate($basket['lastmod'])); ?></small><br>
<small><i class="fa-solid fa-user"></i> <?php print($basket['nick']); ?></small>
<div id="items" class="my-4">
	<?php
		$x=0;
		foreach($items as $item) { 
			$itemData = Flight::get_item_data($item['item_vid']);
			if($itemData != false)
				Flight::render('single_item', ['item'=>Flight::get_item_data($item['item_vid']), 'item_id'=>$item['item_id']]);
			else $x++;
		}
	?>
</div>
<?php if($x > 0) { ?>
	<div class="alert alert-info"><?php print($x); ?> przedmiotów nie zostało wyświetlonych, ponieważ zostały one usunięte z Vinted.</div>
<?php } ?>

<div class="my-3 py-3 rounded" style="background:#dedede;">
	<div class="text-center lh-sm mb-3">
		<i class="fa-solid fa-share"></i><br>Kreacja się spodobała?<br>Udostępnij ją swoim znajomym!
	</div>
	<div class="d-flex justify-content-center a2a_kit a2a_kit_size_32 a2a_default_style">
		<!-- AddToAny BEGIN -->
		<a class="a2a_button_facebook"></a>
		<a class="a2a_button_facebook_messenger"></a>
		<a class="a2a_button_twitter"></a>
		<a class="a2a_button_copy_link"></a>
		<a class="a2a_button_email"></a>
		<a class="a2a_button_sms"></a>
	</div>
	<script>
	var a2a_config = a2a_config || {};
	a2a_config.locale = "pl";
	</script>
	<script async src="https://static.addtoany.com/menu/page.js"></script>
	<!-- AddToAny END -->
</div>
<h4 class="text-center mt-4">Komentarze</h4>
<div class="text-center">
	<div class="fb-comments" data-href="<?php print(Flight::getConfig('url')); ?>/kreacja/<?php print($basket['basket_id']); ?>" data-width="" data-numposts="10"></div>
</div>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v18.0&appId=1944971825565097" nonce="6MILBxsR"></script>

<script>
	function deleteItem(id) {
		if(confirm("Czy na pewno chcesz usunąć ten przedmiot z kreacji?")) {
		  var xhr = new XMLHttpRequest();
		  var req = "<?php print(Flight::getConfig('url')); ?>/ajax/deleteItem/";
		  xhr.open("POST", req+id, true);
		  xhr.setRequestHeader("Content-Type", "application/json");
		  xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
			  var response = JSON.parse(xhr.responseText);
			  if (response.success)
				location.reload();
			  else
				alert('Wystąpił błąd.');
			}
		  };
		  xhr.send(JSON.stringify());
		}
	}
</script>