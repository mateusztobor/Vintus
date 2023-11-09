<?php
	Flight::map('get_search_data', function() {
		Flight::requireFunction('get_cookie');
		Flight::requireFunction('get_web_page');
		$cookie = Flight::get_cookie("https://www.vinted.pl/");
		if(isset($_GET['search_text']))
			$q['search_text'] = $_GET['search_text'];
		else
			return 0;
		$q['per_page'] = '200';
		$q = http_build_query($q);
		if(isset($_GET)) {
			foreach($_GET as $key => $value) {
				if($key != 'search_text') {
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
		return Flight::get_web_page("https://www.vinted.pl/api/v2/catalog/items?".$q, '_vinted_fr_session='.$cookie);
	});