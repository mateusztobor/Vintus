<?php
	Flight::map('notFound', function(){
		Flight::render('main', [
			'tpl'=>'errors/404'
		]);
		Flight::stop(404);
	});
?>