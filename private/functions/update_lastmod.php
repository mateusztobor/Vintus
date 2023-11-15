<?php
	Flight::map('update_lastmod', function($basket_id){
		return Flight::db()->update('baskets', ['lastmod'=>date('Y-m-d')], ['basket_id'=>$basket_id]);
	});