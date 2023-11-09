<?php
	Flight::map('msgs', function() {
		$ret = '';
		if(isset($_SESSION['msgs'])) {
			if(is_array($_SESSION['msgs'])) {
				$ret .= '<div class="toast-container position-fixed end-0 p-3" style="top:50px;">';
				foreach($_SESSION['msgs'] as $msg) {
					$ret .= '<div class="toast align-items-center text-bg-'.$msg['type'].' border-1 shadow" role="alert" data-bs-autohide="true" data-bs-delay="5000"><div class="d-flex"><div class="toast-body">'.$msg['content'].'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
				}
				$ret .= '</div>';
				
			}
			unset($_SESSION['msgs']);
		}
		return $ret;
	});
	Flight::map('msg_add', function($type,$content) {
		$_SESSION['msgs'][] = ['type'=>$type, 'content'=>$content];
	});
	Flight::map('requireFunction', function($name) {
		$path = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'functions/'.$name.'.php';
		if(file_exists($path)) {
			require $path;
			return true;
		} else return false;
	});
?>