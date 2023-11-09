<?php
	Flight::map('getAgreementFiles', function($agreement_id) {
		$path = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'agreements'.DIRECTORY_SEPARATOR.$agreement_id;
		$return=[];
		if(is_dir($path)) {
			$files = glob($path. '/*.{webp,pdf}', GLOB_BRACE);
			foreach($files as $file) {
				$return[] = basename($file);
			}
		}
		return $return;
	});