<?php
	Flight::map('filter_FurlId', function($value=null, $min=1, $max=null){
		if(filter_var($value, FILTER_VALIDATE_INT)) {
			if($value < $min) return false;
			elseif($max != null && $value > $max) return false;
			else return true;
		} else return false;
	});