<?php
	Flight::map('generateString', function($len) {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%&*';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i <= $len; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	});