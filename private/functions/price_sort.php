<?php
	Flight::map('price_sort', function($arr,$asc=true) {
		usort($arr, function($a, $b) use ($asc) {
			return ($asc) ? ($a['price'] - $b['price']) : ($b['price'] - $a['price']);
		});
		return $arr;
	});