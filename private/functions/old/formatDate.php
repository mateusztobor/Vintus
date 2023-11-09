<?php
	Flight::map('formatDate', function($date) {
		$date = strtotime($date);
		return date('d.m.Y', $date);
	});