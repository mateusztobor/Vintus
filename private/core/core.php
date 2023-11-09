<?php
	require dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'flight'.DIRECTORY_SEPARATOR.'Flight.php';
	require __DIR__.'/conf.core.php';
	error_reporting((Flight::getConfig('debug') ? E_ALL : 0));
	date_default_timezone_set(Flight::getConfig('timezone'));
	require __DIR__.'/apps.core.php';
	require __DIR__.'/ver.core.php';
	require __DIR__.'/err.core.php';
	require __DIR__.'/db.core.php';
	require __DIR__.'/func.core.php';
	Flight::runApps();
	Flight::start();
	Flight::destroy();