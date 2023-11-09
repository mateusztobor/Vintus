<?php
	Flight::map('session_register', function($uid){
		$_SESSION[Flight::getConfig('session_name')] = $uid;
		Flight::redirect(Flight::getConfig('url'));
	});
	Flight::map('session_destroy', function(){
		unset($_SESSION[Flight::getConfig('session_name')]);
		Flight::redirect(Flight::getConfig('url'));
	});
	if(isset($_SESSION[Flight::getConfig('session_name')])) {
		$q = Flight::db()->select('users', ['users.first_name','users.second_name','users.phone_number', 'users.email', 'users.manager'],['user_id'=>$_SESSION[Flight::getConfig('session_name')], 'LIMIT'=>1]);
		if($q) {
			$q=$q[0];
			$roles[] = 'logged';
			if($q['manager']) $roles[] = 'manager';
			Flight::set(md5('system.user'), array(
				'id'=>$_SESSION[Flight::getConfig('session_name')],
				'first_name'=>$q['first_name'],
				'second_name'=>$q['second_name'],
				'phone_number'=>$q['phone_number'],
				'email'=>$q['email'],
				'roles'=>$roles
			));
			unset($roles);
			unset($q);
		} else Flight::session_destroy();
	} else {
		Flight::set(md5('system.user'), array('roles'=>[]));
	}
	Flight::map('user', function($q=null){
		if(!is_null($q)) return Flight::get(md5('system.user'))[$q];
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
			Flight::session_destroy();
		});
	} else {
		Flight::route('/logowanie', function() {
			require __DIR__.'/class/auth.class.php';
			$controller = new auth();
			$controller->view();
		});
	}