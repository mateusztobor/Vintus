<?php
	Flight::map('countReportFiles', function($report_id) {
		$path = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'reports'.DIRECTORY_SEPARATOR.$report_id;
		if(is_dir($path))
			return count(glob($path. '/*.{webp,pdf}', GLOB_BRACE));
		return 0;
	});