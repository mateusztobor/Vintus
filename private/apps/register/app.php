<?php
	if(!Flight::isAuthorized('logged')) {
		Flight::route('/rejestracja', function(){
			require  __DIR__.'/class/register.class.php';
			$controller = new register();
			$controller->view();
		});
	}