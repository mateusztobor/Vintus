<?php
	if(Flight::isAuthorized('logged')) {
		Flight::route('/zmien-haslo', function(){
			require  __DIR__.'/class/chpass.class.php';
			$controller = new chpass();
			$controller->view();
		});
	}