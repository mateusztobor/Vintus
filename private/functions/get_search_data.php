<?php
	Flight::map('get_search_data', function() {
		Flight::requireFunction('get_cookie');
		Flight::requireFunction('get_web_page');
		$cookie = Flight::get_cookie("https://www.vinted.pl/");
		if(isset($_GET['search_text']))
			$q['search_text'] = $_GET['search_text'];
		else
			return false;
		
		if(isset($_GET['p'])) {
			if((int)$_GET['p'] == $_GET['p']) {
				if($_GET['p'] <= 0)
					$_GET['p']=1;
			} else $_GET['p']=1;
		} else $_GET['p']=1;
		
		$q['per_page'] = Flight::getConfig('items_accuracy');
		$q['page'] = (int)(($_GET['p']*Flight::getConfig('items_per_page'))/Flight::getConfig('items_accuracy')) + 1;
		
		//tak długo jak p jest wieksze od Flight::getConfig('items_accuracy')/Flight::getConfig('items_per_page')
		
		while($_GET['p'] > (Flight::getConfig('items_accuracy')/Flight::getConfig('items_per_page'))) {
			$_GET['p'] -= (Flight::getConfig('items_accuracy')/Flight::getConfig('items_per_page'));
		}
		
		$q = http_build_query($q);
		if(isset($_GET)) {
			foreach($_GET as $key => $value) {
				if($key != 'search_text' && $key != 'per_page' && $key != 'page') {
					if(is_array($value)) {
						foreach($value as $valu) {
							$q .= $key.'[]='.$valu.'&';
						}
					} else 
						$q .= $key.'='.$value.'&';
				}
				
			}
			$q = substr_replace($q ,"",-1);
		}
		$arr = json_decode(Flight::get_web_page("https://www.vinted.pl/api/v2/catalog/items?".$q, '_vinted_fr_session='.$cookie),true);
		
		if(!is_array($arr))
			return false;
		if(!isset($arr['items']))
			return false;
		elseif(!is_array($arr['items']))
			return false;
		
		if(isset($_GET['order'])) {
			if($_GET['order'] == 'fav') {
				Flight::requireFunction('fav_sort');
				$arr['items'] = Flight::fav_sort($arr['items'],false);
			} elseif($_GET['order'] == 'unfav') {
				Flight::requireFunction('fav_sort');
				$arr['items'] = Flight::fav_sort($arr['items']);
			} elseif($_GET['order'] == 'price_high_to_low') {
				Flight::requireFunction('price_sort');
				$arr['items'] = Flight::price_sort($arr['items'], false);
			} elseif($_GET['order'] == 'price_low_to_high') {
				Flight::requireFunction('price_sort');
				$arr['items'] = Flight::price_sort($arr['items']);
			}
		}
		
		$arr['items'] = array_chunk($arr['items'], Flight::getConfig('items_per_page'));
		$arr['items'] = $arr['items'][$_GET['p']-1];
		return $arr;
	});