<?php
	Flight::map('countDaysFromDate', function($date) {
		$now = time();
		$date = strtotime($date);
		return round(($now - $date) / (60 * 60 * 24))-1;
	});