<?php
	Flight::map('countOpenedReports', function() {
		return Flight::db()->count('reports', ['closed'=>0]);
	});