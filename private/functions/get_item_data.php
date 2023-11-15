<?php
	Flight::map('get_item_data', function($itemId) {
		if($itemId != (int)$itemId) 
			return false;
		Flight::requireFunction('get_cookie');
		$cookie = Flight::get_cookie("https://www.vinted.pl/");
		Flight::requireFunction('get_web_page');
		$arr = json_decode(Flight::get_web_page("https://www.vinted.pl/api/v2/items/".$itemId, '_vinted_fr_session='.$cookie),true);
		if(!is_array($arr))
			return false;
		if(!isset($arr['item']))
			return false;
		elseif(!is_array($arr['item']))
			return false;
		return $arr['item'];
	});