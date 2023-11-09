<?php
	Flight::map('getReportFiles', function($report_id) {
		$path = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'reports'.DIRECTORY_SEPARATOR.$report_id;
		$return=[];
		if(is_dir($path)) {
			$files = glob($path. '/*.{webp,pdf}', GLOB_BRACE);
			foreach($files as $file) {
				$return[] = basename($file);
			}
		}
		return $return;
	});