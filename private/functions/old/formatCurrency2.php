<?php
	Flight::map('formatCurrency2', function($value) {
	  return number_format(abs($value), 2, '.', '');
	});