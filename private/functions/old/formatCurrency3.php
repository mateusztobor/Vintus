<?php
	Flight::map('formatCurrency3', function($value) {
	  if ($value<0) return "-".Flight::formatCurrency3(-$value);
	  return number_format(abs($value), 2, '.', '');
	});