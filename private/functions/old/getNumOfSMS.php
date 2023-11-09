<?php
	Flight::map('getNumOfSMS', function(){
		$file = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.'numOfSMS.tpl';
		if(file_exists($file))
			return file_get_contents($file);
		return -1;
	});