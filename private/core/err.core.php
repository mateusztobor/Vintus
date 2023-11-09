<?php
	Flight::map('displayError', function($error=500, $code=null, $url=null, $contact='none', $debug=null, $exit=false){
		$tpl = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.$error.'.tpl';
		if(file_exists($tpl)) {
			$tpl = file_get_contents($tpl);
			if($debug != null) {
				if(!empty($debug)) {
					$debug = '<div class="d debug"><h2>DEBUG-MODE=ON</h2><strong>Error info:</strong> '.$debug;
					$debug .= '<hr>';
					$debug .= '<strong>PHP:</strong> version: '.phpversion().', memory: '.@round(memory_get_usage()/pow(1024,($i=floor(log(memory_get_usage(),1024)))),2).array('B','K','M','G','T','P')[$i].'/'.ini_get('memory_limit');
					$debug .= '<hr>';
					$debug .= '<strong>Enabled CORE:</strong><Br>';
					if(isset(Flight::getEnabledApps()['core'])) {
						if(is_array(Flight::getEnabledApps()['core'])) {
							foreach(Flight::getEnabledApps()['core'] as $app) {
								$debug .= $app['name']. ' (ver. '.$app['ver'].'), ';
							}
						} else $debug .= 'none';
					} else $debug .= 'none';
					$debug .= '<hr>';
					$debug .= '<strong>Enabled APPS:</strong><Br>';
					if(isset(Flight::getEnabledApps()['app'])) {
						if(is_array(Flight::getEnabledApps()['app'])) {
							foreach(Flight::getEnabledApps()['app'] as $app) {
								$debug .= $app['basename']. ' (ver. '.$app['ver'].'), ';
							}
						} else $debug .= 'none';
					} else $debug .= 'none';
					
					$debug .= '</div>';
				}
			}
			
			$tpl = str_replace(
				array('{{url}}','{{code}}','{{contact}}','{{debug}}'),
				array($url,$code,$contact,$debug)
			,$tpl);
			echo $tpl;
			return($tpl);
			if($exit) exit();
		} else return '<h1>Error '.$error.'</h1>'.$code;
	});
?>