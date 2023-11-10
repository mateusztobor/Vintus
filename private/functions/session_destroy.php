<?php
	Flight::map('session_destroy', function(){
		unset($_SESSION[Flight::getConfig('session_name')]);
		Flight::redirect(Flight::getConfig('url'));
	});