<?php
	Flight::route('/public/jsp/@file', function($file) {
		$path = dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.$file;
		if(file_exists($path)) {
			$file = file_get_contents($path);
			$file = str_replace(
				[
					'{jsp$url}'
				],
				[
					Flight::getConfig('url')
				],
				$file);
			echo $file;
		} else Flight::notFound();
	});