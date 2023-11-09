<?php
	Flight::route('/', function(){
		Flight::setCurrentApp('/start');
		Flight::render('main', ['tpl'=>'search']);
		
	});