<?php
	Flight::map('getRaportTpl', function($tpl) {
		$pathTpl = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.'owner_report'.DIRECTORY_SEPARATOR.$tpl.'.html';
		if(file_exists($pathTpl))
			return file_get_contents($pathTpl);
		return false;
	});