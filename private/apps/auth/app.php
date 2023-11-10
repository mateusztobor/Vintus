<?php
	if(isset($_SESSION[Flight::getConfig('session_name')])) {
		$q = Flight::db()->get('users', ['users.nick','users.email','users.user_id'],['user_id'=>$_SESSION[Flight::getConfig('session_name')], 'LIMIT'=>1]);
		if($q) {
			$roles[] = 'logged';
			Flight::set(md5('system.user'), array(
				'id'=>$_SESSION[Flight::getConfig('session_name')],
				'nick'=>$q['nick'],
				'email'=>$q['email'],
				'roles'=>$roles
			));
			unset($roles);
			unset($q);
		} else {
			Flight::requireFunction('session_destroy');
			Flight::session_destroy();
		}
	} else {
		Flight::set(md5('system.user'), ['roles'=>[]]);
	}
	Flight::map('user', function($q=null){
		if(!is_null($q))
			return (isset(Flight::get(md5('system.user'))[$q]) ? Flight::get(md5('system.user'))[$q] : '');
		return Flight::get(md5('system.user'));
	});
	Flight::map('isAuthorized', function($q){
		if(in_array($q,Flight::get(md5('system.user'))['roles']))
			return true;
		return false;
	});
	if(Flight::isAuthorized('logged')) {
		Flight::route('/wyloguj', function(){
			Flight::msg_add('success', 'Wylogowano pomyślnie.');
			Flight::requireFunction('session_destroy');
			Flight::session_destroy();
		});
	} else {
		Flight::route('/logowanie', function() {
			require __DIR__.'/class/auth.class.php';
			$controller = new auth();
			$controller->view();
		});
	}