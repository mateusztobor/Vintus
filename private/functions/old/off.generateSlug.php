<?php
	Flight::map('generateSlug', function($title) {
		$title = strtr($title, [
			'ą' => 'a',
			'ć' => 'c',
			'ę' => 'e',
			'ł' => 'l',
			'ń' => 'n',
			'ó' => 'o',
			'ś' => 's',
			'ź' => 'z',
			'ż' => 'z',
			'Ą' => 'A',
			'Ć' => 'C',
			'Ę' => 'E',
			'Ł' => 'L',
			'Ń' => 'N',
			'Ó' => 'O',
			'Ś' => 'S',
			'Ź' => 'Z',
			'Ż' => 'Z'
		]);
		$title = preg_replace('/[^a-zA-Z0-9\s]/', '', $title);
		$title = str_replace(' ', '-', $title);
		$title = strtolower($title);
		$title = preg_replace('/-+/', '-', $title);
		$title = rtrim($title, '-');
		return $title;
	});