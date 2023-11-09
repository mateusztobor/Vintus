<?php
	Flight::map('checkSlug', function($variable) {
		return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $variable);
	});