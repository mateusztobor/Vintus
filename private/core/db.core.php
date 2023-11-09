<?php
	Flight::initApp('core',array(
		"name"=>"Medoo",
		"desc"=>"PHP library",
		"ver"=>"2.1.10",
		"site"=>"https://medoo.in"
	));
	require dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'medoo'.DIRECTORY_SEPARATOR.'Medoo.php';
	use Medoo\Medoo;
	Flight::register('db','Medoo\Medoo',Flight::getConfig('database'));
	try {
		Flight::db();
		Flight::setConfig('db_connected',true);
	} catch(\PDOException $e) {
		$debug = null;
		if(Flight::getConfig('debug')) {
			$debug .= 'Unable connect to database';			
		}
		Flight::halt(500,Flight::displayError(500,'dbc',Flight::getConfig('url'),Flight::getConfig('dev.email'),$debug));
	}
	Flight::after('start', function(&$params, &$output){
		if (Flight::db()->error) {
			$debug = null;
			if(Flight::getConfig('debug')) {
				$debug .= Flight::db()->error;
				$debug .= "<br>";
				$debug .= Flight::db()->last();
			}
			Flight::halt(500,Flight::displayError(500,'dbq',Flight::getConfig('url'),Flight::getConfig('dev.email'),$debug));
		}
	});
?>