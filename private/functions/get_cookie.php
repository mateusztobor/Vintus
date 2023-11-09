<?php
	Flight::map('get_cookie', function($url) {
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => true,     //return headers in addition to content
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLINFO_HEADER_OUT    => true,
			CURLOPT_SSL_VERIFYPEER => true,     // Validate SSL Certificates
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$rough_content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header_content = substr($rough_content, 0, $header['header_size']);
		$body_content = trim(str_replace($header_content, '', $rough_content));
		$pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m"; 
		preg_match_all($pattern, $header_content, $matches); 
		$cookiesOut = implode("; ", $matches['cookie']);

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['headers']  = $header_content;
		$header['content'] = $body_content;
		$header['cookies'] = $cookiesOut;

		$link = $header['cookies'];
		$pos_start = strpos($link, '_vinted_fr_session');
		$sub_string = substr($link, $pos_start);
		$pos_end = strpos($sub_string, ';');
		$sub_string = substr($sub_string, 19, $pos_end-19);
		return $sub_string;
	});