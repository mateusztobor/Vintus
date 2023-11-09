<?php
	Flight::map('fav_sort', function($arr,$asc=true) {
		usort($arr, function($a, $b) use ($asc) {
			return ($asc) ? ($a['favourite_count'] - $b['favourite_count']) : ($b['favourite_count'] - $a['favourite_count']);
		});
		return $arr;
	});