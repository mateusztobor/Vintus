<?php
	Flight::map('session_register', function($uid){
		$_SESSION[Flight::getConfig('session_name')] = $uid;
		Flight::redirect(Flight::getConfig('url'));
	});