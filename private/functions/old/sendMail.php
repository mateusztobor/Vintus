<?php
	Flight::map('sendMail', function($to, $subject, $content) {
		if(filter_var($to, FILTER_VALIDATE_EMAIL)) {
			$from = 'noreply@vintus.pl'; 
			$fromName = 'Vintuś';
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
			return mail($to, $subject, $content, $headers);
		}
	});