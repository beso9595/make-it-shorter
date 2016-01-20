<?php
	require_once "database.php";
	require_once "config.php";
	require_once "language.php";
	
	$err = '/../404.php';
	
	if(isset($_POST["hostname"])){
		if(!file_exists("../install.php")){
			header("Location: $err");
			exit;
		}
		$arr["address"] = $_POST["address"];
		unset($_POST["address"]);
		$arr["sitename"] = $_POST["sitename"];
		unset($_POST["sitename"]);
		$arr["title"] = $_POST["title"];
		unset($_POST["title"]);
		$arr["hostname"] = $_POST["hostname"];
		unset($_POST["hostname"]);
		$arr["username"] = $_POST["username"];
		unset($_POST["username"]);
		$arr["password"] = $_POST["password"];
		unset($_POST["password"]);
		$arr["database"] = $_POST["database"];
		unset($_POST["database"]);
		$arr["prefix"] = $_POST["prefix"];
		unset($_POST["prefix"]);
		$arr["sec_word"] = $_POST["sec_word"];
		unset($_POST["sec_word"]);
		$arr["mail"] = $_POST["mail"];
		unset($_POST["mail"]);
		$arr["language"] = $_POST["language"];
		unset($_POST["language"]);
		//
		$str = "";
		$k = 0;
		foreach($arr as $key => $value){
			if($value == "" && $key != "password"){
				$str .= " " . ucfirst($key) . ",";
				$k++;
			}
		}
		if($str != ""){
			exit("Empty field(s): " . substr($str, 0, -1) . ".");
		}
		if(!filter_var($arr["address"], FILTER_VALIDATE_URL)){
			exit("Invalid web address [check 'http://'].");
		}
		if($arr["mail"] != "" && !filter_var($arr["mail"], FILTER_VALIDATE_EMAIL)){
			exit("Invalid e-mail syntax.");
		}
		//
		$db = @new mysqli($arr["hostname"], $arr["username"], $arr["password"], $arr["database"]);
		if ($db->connect_error) {
			exit("Database connection problem");
		}
		$db->close();
		if(!file_exists("../data/database.sql")){
			exit("Couldn't find file: '/data/database.sql'");
		}
		//
		$f_config = fopen("../data/config.ini", "w");
		foreach($arr as $key => $value){
			fwrite($f_config, ($key . "=" . $value . ";\n"));
		}
		fclose ($f_config);
		unset($arr);
		//
		$f = file_get_contents("../data/database.sql");
		$f = str_replace("%prefix%", Config::get("prefix"), $f);
		if(DB::createTB($f)){
			exit("Successfully connected to the database. Refresh page.");
		}
	}
	elseif(isset($_POST["link"])){
		$link = $_POST["link"];
		unset($_POST["link"]);
		checkLink($link);
		//
		if(DB::existsLink($link)){
			$code = DB::getCode($link);
		}
		else{
			while(true){
				$time = time();
				$code = generate($time);
				if(!DB::existsCode($code)){
					break;
				}
			}
			if(!DB::save($link, $code, $time)){
				exit(Lang::get("ERR_SAVING_IN_DB"));
			}
		}
		
		exit($_SERVER['HTTP_HOST'] . "/" . $code);
	}
	elseif(isset($_POST["c_link"])){
		$link = $_POST["c_link"];
		$code = $_POST["code"];
		unset($_POST["c_link"]);
		unset($_POST["code"]);
		checkLink($link);
		checkCode($code);
		//
		if(DB::existsCode($code)){
			exit(Lang::get("CODE_ALREADY_EXISTS"));
		}
		if(!DB::save($link, $code)){
			exit(Lang::get("ERR_SAVING_IN_DB"));
		}
		
		exit($_SERVER['HTTP_HOST'] . "/" . $code);
	}
	else{
		header("Location: $err");
		exit;
	}
	
	function generate($time){
		return substr(md5(Config::get("sec_word") . $time), 7, Config::$code_len);
	}
	
	function checkLink($link){
		if($link == ""){
			exit(Lang::get("FILL_LINK_FIELD"));
		}
		if(strlen($link) > Config::$link_max_len || strlen($link) < Config::$link_min_len){
			exit(Lang::get("LINK_LIMIT") . " [" . Config::$link_min_len . "," . Config::$link_max_len . "]");
		}
		if(!filter_var($link, FILTER_VALIDATE_URL) || !(strpos($link,'.')) || !((strlen($link) - strripos($link,'.')) >= 3)){
			exit(Lang::get("INVALID_LINK"));
		}
	}
	
	function checkCode($code){
		if($code == ""){
			exit(Lang::get("FILL_CODE_FIELD"));
		}
		if(strlen($code) > Config::$code_max_len || strlen($code) < Config::$code_min_len){
			exit(Lang::get("CODE_LIMIT") . " [" . Config::$code_min_len . "," . Config::$code_max_len . "]");
		}
		if(!ctype_alnum($code)){
			exit(Lang::get("INVALID_CODE"));
		}
	}
	
?>