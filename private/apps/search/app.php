<?php
	Flight::route('/search', function(){
		Flight::requireFunction('get_search_data');
		$items = Flight::get_search_data();
		if($items !== false) {
			foreach($items['items'] as $item) {
				Flight::render('single_item', ['item'=>$item]);
			}
		} else Flight::render('no_results');
	});