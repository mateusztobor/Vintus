<?php
	if(Flight::isAuthorized('logged')) {
		Flight::route('/moje-kreacje', function(){
			Flight::setCurrentApp('/moje-kreacje');
			Flight::render('main', ['tpl'=>'creations']);
		});
		Flight::route('/ajax/loadMyBaskets', function() {
			Flight::requireFunction('formatDate');
			$baskets = Flight::db()->select('baskets', ['basket_id', 'name', 'lastmod'], ['user_id'=>Flight::user('id'), 'ORDER'=>['lastmod'=>'DESC', 'basket_id'=>'DESC']]);
			Flight::render('baskets', ['baskets'=>$baskets]);
		});
		Flight::route('/ajax/deleteMyBasket/@id', function($id){
			$del = Flight::db()->delete('baskets', ['basket_id'=>$id, 'user_id'=>Flight::user('id')]);
			$data = array('success'=>$del);
			echo json_encode($data,JSON_UNESCAPED_SLASHES);
			unset($data);
		});
		Flight::route('/ajax/createBasket', function(){
			$data = ['success'=>false];
			if(isset(Flight::request()->data->name)) {
				if(mb_strlen(Flight::request()->data->name) <= 128) {
					$insert = Flight::db()->insert('baskets', ['name'=>htmlspecialchars(Flight::request()->data->name), 'user_id'=>Flight::user('id')]);
					$data = ['success'=>$insert];
				}
			}
			echo json_encode($data,JSON_UNESCAPED_SLASHES);
			unset($data);
		});
		Flight::route('/kreacja/@id:[0-9]+', function($id){
			$basket=Flight::db()->get('baskets', ['[>]users' => ['baskets.user_id'=>'user_id']], ['basket_id', 'name','lastmod','users.nick', 'users.user_id'], ['basket_id'=>$id]);
			if($basket) {
				Flight::requireFunction('formatDate');
				Flight::requireFunction('formatCurrency');
				Flight::requireFunction('get_item_data');
				$items = Flight::db()->select('baskets_items', ['[>]baskets'=>['basket_id', 'basket_id']], ['item_id', 'item_vid', 'baskets.user_id'], ['basket_id'=>$id]);
				$isOwner = Flight::isAuthorized('logged') ? (Flight::user('id') == $basket['user_id']) : false;
				Flight::render('main', ['tpl'=>'creation', 'basket'=>$basket, 'items'=>$items, 'isOwner'=>$isOwner]);
			} else Flight::notFound();
		});
		Flight::route('/ajax/deleteItem/@id', function($id){
			$data = array('success'=>false);
			$basket_id = Flight::db()->get('baskets_items', ['basket_id'], ['item_id'=>$id]);
			if($basket_id) {
				if(Flight::db()->has('baskets', ['user_id'=>Flight::user('id'), 'basket_id'=>$basket_id['basket_id']])) {
					$del = Flight::db()->delete('baskets_items', ['item_id'=>$id]);
					$data = array('success'=>$del);
				}
			}
			echo json_encode($data,JSON_UNESCAPED_SLASHES);
			unset($data);
		});
	}