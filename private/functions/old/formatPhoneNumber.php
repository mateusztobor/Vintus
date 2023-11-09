<?php
	Flight::map('formatPhoneNumber', function($phoneNumber) {
		$phoneNumber = strrev($phoneNumber);
		$phoneNumber = chunk_split($phoneNumber, 3, ' ');
		return strrev(trim($phoneNumber));
	});