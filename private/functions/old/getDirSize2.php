<?php
	Flight::map('getDirSize2', function($dir) {
		$total=0;
		$files = glob($dir.DIRECTORY_SEPARATOR.'*'); 
		foreach($files as $file) { 
			if(is_dir($file)) {
				$files2 = glob($file.DIRECTORY_SEPARATOR.'*'); 
				foreach($files2 as $file2) {
					if(is_file($file2))
						$total+=filesize($file2);
				}
			}
			elseif(is_file($file))
				$total+=filesize($file);
		}
		return $total;
	});