<?php
	Flight::map('howTimeAgo', function($date){
		$seconds_ago = (time() - strtotime($date));
		if ($seconds_ago >= 31536000) {
			return intval($seconds_ago / 31536000) . " lat temu";
		} elseif ($seconds_ago >= 2419200) {
			return intval($seconds_ago / 2419200) . " miesięcy temu";
		} elseif ($seconds_ago >= 86400) {
			return intval($seconds_ago / 86400) . " dni temu";
		} elseif ($seconds_ago >= 3600) {
			return intval($seconds_ago / 3600) . " godzin temu";
		} elseif ($seconds_ago >= 60) {
			return intval($seconds_ago / 60) . " minut temu";
		} else {
			echo "Teraz";
		}
	});