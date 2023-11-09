<?php
	Flight::map('formatCurrency', function($price, $code) {
		Flight::requireFunction('getCurrency');
		if($price<0)
			return "-".Flight::formatCurrency(-$price);
		return number_format($price, 2, ',', ' ').' '.Flight::getCurrency($code);
	});