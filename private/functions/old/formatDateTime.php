<?php
	Flight::map('formatDateTime', function($date){
		$polishDateFormatter = new IntlDateFormatter(
			'pl_PL',
			IntlDateFormatter::LONG,
			IntlDateFormatter::NONE
		);
		$now = new DateTime($date);
		return $polishDateFormatter->format($now);
	});