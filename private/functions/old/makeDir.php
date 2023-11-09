<?php
	Flight::map('makeDir', function($dir) {
		if(!is_dir($dir))
			mkdir($dir);
	});