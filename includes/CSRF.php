<?php
	require_once('helpers.php');
	require_once('Session.php');
	require_once(__DIR__.'/../loader.php');
	
	class CSRF
	{		
		public static function token()
		{
			if(empty($_SESSION['token']))
			{
				$token = bin2hex(openssl_random_pseudo_bytes(32));
				$_SESSION['token'] = $token;
				return $token;
			} else {
				$token = $_SESSION['token'];
				return $token;
			}
		}
		
		public static function check($token)
		{
			if(hash_equals($token, $_SESSION['token'])){
				return true;
			} else {
				return false;		
			}
		}
	}