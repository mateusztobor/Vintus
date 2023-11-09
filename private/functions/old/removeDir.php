<?php
	Flight::map('removeDir', function($dir) {
		if(is_dir($dir)) {
			$files = glob($dir.DIRECTORY_SEPARATOR.'*');
			foreach($files as $file) { 
				if(is_file($file))  
					unlink($file); 
				elseif(is_dir($file))
					rmdir($file);
			}
			rmdir($dir);
		}
	});