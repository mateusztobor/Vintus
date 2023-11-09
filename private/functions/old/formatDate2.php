<?php
	Flight::map('formatDate2', function($date) {
		$date = strtotime($date);
		return date('d.m.Y H:i:s', $date);
	});