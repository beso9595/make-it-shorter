<?php
	
	class Config{
		
		public static function get($key){
			if(file_exists("/../data/config.ini")){
				echo $key;
				die("Missing config file!");
			}
			$dir = dirname(__DIR__) . "/data/config.ini";
			$data = parse_ini_file($dir);
			return $data[$key];
		}
		
		public static $link_max_len = 50000;
		public static $link_min_len = 10;
		public static $code_len = 7;
		public static $code_max_len = 20;
		public static $code_min_len = 5;
	}
	
?>