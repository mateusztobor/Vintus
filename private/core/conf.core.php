<?php
	Flight::map('setConfig', function($field,$value) {
		if(Flight::has(md5('system.config')))
			$conf = Flight::get(md5('system.config'));
		$conf[$field] = $value;
		Flight::set(md5('system.config'),$conf);
	});
	Flight::setConfig('db_connected',false);
	Flight::map('getConfig', function($field) {
		if(Flight::has(md5('system.config'))) {
			if(isset(Flight::get(md5('system.config'))[$field]))
				return Flight::get(md5('system.config'))[$field];
			elseif(Flight::getConfig('db_connected') == true) {
				$q = Flight::db()->select('settings', 'value',['field'=>$field]);
				if($q) {
					Flight::setConfig($field,$q[0]);
					return $q[0];
				}
			}
		}
		return null;
	});
	Flight::map('setArrConfig', function($field,$value,$key) {
		if(Flight::has(md5('system.config')))
			$conf = Flight::get(md5('system.config'));
		$conf[$field][$key] = $value;
		Flight::set(md5('system.config'),$conf);
	});
	Flight::map('addAppsDynData', function($appID,$appContent) {
		if(Flight::has(md5('system.appsdyndata')))
			$ADD = Flight::get(md5('system.appsdyndata'));
		$ADD[0][] = $appID;
		$ADD[1][] = $appContent;
		Flight::set(md5('system.appsdyndata'),$ADD);
	});
	Flight::addAppsDynData('{url}', Flight::getConfig('url'));
	Flight::map('getAppsDynData', function() {
		if(Flight::has(md5('system.appsdyndata')))
			return Flight::get(md5('system.appsdyndata'));
		return [0=>null,1=>null];
	});
	require dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'config.php';
	//security
	Flight::setConfig('session_name',md5('HJYI^C!p+d!3$J1'));
	Flight::setConfig('password_hash',md5('l4wE81y+fltdK,E'));
	Flight::setConfig('cron_key','_jt4^1Z6dGu');
	//others
	Flight::set('flight.base_url', Flight::getConfig('url'));
	Flight::set('flight.case_sensitive', true);
	Flight::set('flight.handle_errors', true);
	Flight::set('flight.log_errors', true);
	Flight::set('flight.views.path', dirname(__DIR__, 1).'/tpl');
	Flight::set('flight.views.extension', '.tpl');
	Flight::map('destroy', function(){
		Flight::clear(md5('system.config'));
		Flight::clear(md5('system.appsdyndata'));
		Flight::clear(md5('system.enabled_apps'));
		Flight::clear(md5('system.user'));
		Flight::map('db', function(){return false;});
	});
?>