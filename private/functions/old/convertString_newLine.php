<?php
	Flight::map('convertString_newLine', function($text) {
		return str_replace("\n", "<br>", $text);
	});