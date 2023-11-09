<?php
	Flight::map('formatCurrency', function($value) {
	  if ($value<0) return "-".Flight::formatCurrency(-$value);
	  return number_format($value, 2, ',', ' ').' zł';
	});