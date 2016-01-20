<?php
	require_once "config.php";

	class Lang{
		
		public static function get($key){
			$lang;
			if(isset($_COOKIE["lang"])){
				$lang = $_COOKIE["lang"];
			}
			else{
				$lang = Config::get("language");
			}
			$dir = dirname(__DIR__) . "/data/lang/lang_" . $lang . ".ini";
			$data = parse_ini_file($dir);
			return $data[$key];
		}
		
		public static function getByLang($lang, $key){
			$dir = dirname(__DIR__) . "/data/lang/lang_" . $lang . ".ini";
			$data = parse_ini_file($dir);
			return $data[$key];
		}
		
		public static function getIndexArray(){
			$arr = glob('data/lang/*.ini');
			for($i = 0; $i < count($arr); $i++){
				$arr[$i] = substr($arr[$i], -6, -4);
			}
			return $arr;
		}
	}
?>