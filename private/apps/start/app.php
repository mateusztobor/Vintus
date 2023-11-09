<?php
	Flight::route('/', function(){
		Flight::setCurrentApp('/start');
		Flight::requireFunction('get_search_data');
		$content = Flight::get_search_data('buty adidas');
		//echo Flight::request()->data->kaja;
		//echo $_GET['kaja'];
		//foreach($_GET['kaja'] as $kaja) {
		//	echo $kaja;
		//}
		Flight::render('main', ['content'=>$content]);
		
	});