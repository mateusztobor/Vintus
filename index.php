<?php
	$start = microtime(true);
	ob_start();
	
	session_start();
	header('Content-Type:text/html;charset=utf-8');
	
	require 'private/core/core.php';
	ob_end_flush();
	
?>