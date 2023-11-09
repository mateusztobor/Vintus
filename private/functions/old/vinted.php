<?php
	Flight::map('checkPaymentPDF', function($id) {
		return file_exists(dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'payments'.DIRECTORY_SEPARATOR.$id.'.pdf');
	});