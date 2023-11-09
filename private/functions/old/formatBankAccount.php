<?php
	Flight::map('formatBankAccount', function($value) {
		if (strlen($value) == 26) {
			$value = preg_replace('/\D/', '', $value);
			$value = str_pad($value, 26, '0', STR_PAD_LEFT);
			$value = substr($value, 0, 2) . ' ' . implode(' ', str_split(substr($value, 2), 4));
			return $value;
		}
		return $value;
	});