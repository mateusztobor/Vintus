<?php
	Flight::setConfig('url','http://localhost/vintus');
	Flight::setConfig('timezone','Europe/Warsaw');
	Flight::setConfig('items_per_page',5);
	Flight::setConfig('items_accuracy',200);
	Flight::setConfig('database',
		array(array(
			'type' => 'mysql',
			'host' => 'localhost',
			'database' => 'vintus',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_bin',
			'port' => 3306,
			'prefix' => '',
			'logging' => false,
			'error' => PDO::ERRMODE_SILENT,
			'option' => [
				PDO::ATTR_CASE => PDO::CASE_NATURAL
			],
			'command' => [
				'SET SQL_MODE=ANSI_QUOTES'
			]
	)));
	//advanced
	Flight::setConfig('debug', 1);
?>