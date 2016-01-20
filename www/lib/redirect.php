<?php
	require_once "config.php";
	require_once "database.php";
	
	function redirect($code){
		$err = '/../404.php';
		if(!checkCode($code)){
			header("Location: $err");
			exit;
		}
		$link = DB::getLink($code);
		if($link == false){
			header("Location: $err");
			exit;
		}
		if(!DB::increase($code)){
			header("Location: $err");
			exit;
		}
		header("Location: $link");
		exit;
	}
	
	function checkCode($code){
		if(strlen($code) > Config::$code_max_len || strlen($code) < Config::$code_min_len || !ctype_alnum($code)){
			return false;
		}
		return true;
	}
	
?>