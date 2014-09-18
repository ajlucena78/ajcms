<?php
	session_start();
	$_SESSION['uso_cookies'] = true;
	if (isset($_SERVER['HTTP_REFERER']) and $_SERVER['HTTP_REFERER'])
		header('Location:' . $_SERVER['HTTP_REFERER']);
	else
		header('Location:/');