<?php
	Flight::map('initApp', function($type,$data){
		if($type == 'core' || $type == 'app') {
			if(Flight::has(md5('system.enabled_apps')))
				$arr = Flight::get(md5('system.enabled_apps'));
			if(!isset($data['desc'])) $data['desc'] = NULL;
			if(!isset($data['ver'])) $data['ver'] = NULL;
			if(!isset($data['site'])) $data['site'] = NULL;
			$arr[$type][] = $data;
			Flight::set(md5('system.enabled_apps'),$arr);
		}
	});
	Flight::map('getEnabledApps', function(){
		if(Flight::has(md5('system.enabled_apps'))) return Flight::get(md5('system.enabled_apps'));
		return array();
	});
	Flight::map('setCurrentApp', function($basename){
		Flight::set(md5('system.current_module'),$basename);
	});
	Flight::map('checkCurrentApp', function($expected,$return,$else=false,$echo=true){
		if(Flight::has(md5('system.current_module'))) {
			if($echo) {
				if(Flight::get(md5('system.current_module')) == $expected)
					echo $return;
				else
					echo $else;
			} else {
				if(Flight::get(md5('system.current_module')) == $expected)
					return $return;
				return $else;
			}
		}
	});
	Flight::map('runApps', function(){
		$ini = parse_ini_file(dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR."enabled_apps.ini", false);
		$app_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR;
		foreach($ini['app'] as $app) {
			if(file_exists($app_path.$app.DIRECTORY_SEPARATOR.'app.ini') && file_exists($app_path.$app.DIRECTORY_SEPARATOR.'app.php')) {
				$app_ini = parse_ini_file($app_path.$app.DIRECTORY_SEPARATOR.'app.ini');
				$app_ini['basename'] = $app;
				if(isset($app_ini['name'])) {
					if(!empty($app_ini['name'])) {
						Flight::initApp('app',$app_ini);
						require $app_path.$app.DIRECTORY_SEPARATOR.'app.php';
					}
				}
				unset($app_ini);
			}
		}
		unset($app_path);
		unset($ini);
	});
?>