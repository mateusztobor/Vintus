<?php
	Flight::route('/', function(){
		Flight::setCurrentApp('/start');
		if(Flight::isAuthorized('logged')) {
			$baskets = Flight::db()->select('baskets', ['name', 'basket_id'], ['user_id'=>Flight::user('id')]);
			if(!$baskets)
				$baskets = [];
		} else
			$baskets = [];
		Flight::render('main', ['tpl'=>'search', 'baskets'=>$baskets]);
	});