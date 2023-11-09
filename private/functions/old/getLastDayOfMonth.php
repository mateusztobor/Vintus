<?php
	Flight::map('getLastDayOfMonth', function($date) {
		return date("Y-m-t", strtotime($date));
	});