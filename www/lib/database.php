<?php
	require_once "config.php";
	
	class DB{
		
		public static $db = null;
		
		public static function getDB(){
			if(self::$db === null){
				self::$db = new mysqli(Config::get("hostname"), Config::get("username"), Config::get("password"), Config::get("database"));
				self::$db->query("SET NAMES 'utf8'");
			}
		}
		
		private static function query($query){
			self::getDB();
			return self::$db->query($query);
		}
		
		public static function createTB($content){
			$prefix = Config::get("prefix");
			$result = self::query("SHOW TABLES LIKE '" . $prefix . "links'");
			if($result->num_rows != 0){
				self::query("DROP TABLE " . $prefix . "links");
			}
			$arr = explode(";", $content);
			for($i = 0; $i < count($arr); $i++){
				if($arr[$i] != ""){
					if(!self::query($arr[$i])){
						return false;
					}
				}
			}
			return true;
		}
		
		public static function existsLink($link){
			$result_set = self::query("SELECT `id` FROM `" . Config::get("prefix") . "links` WHERE `url`='" . $link . "'");
			return $result_set->num_rows?true:false;
		}
		
		public static function existsCode($code){
			$result_set = self::query("SELECT `id` FROM `" . Config::get("prefix") . "links` WHERE `code`='" . $code . "'");
			return $result_set->num_rows?true:false;
		}
		
		public static function getLink($code){
			$result_set = self::query("SELECT `url` FROM `" . Config::get("prefix") . "links` WHERE `code`='" . $code . "'");
			if($result_set->num_rows == 0){
				return false;
			}
			elseif($row = $result_set->fetch_assoc()){
				$result_set->close();
				return $row["url"];
			}
			return false;
		}
		
		public static function getCode($link){
			$result_set = self::query("SELECT `code` FROM `" . Config::get("prefix") . "links` WHERE `url`='" . $link . "'");
			if($result_set->num_rows == 0){
				return false;
			}
			elseif($row = $result_set->fetch_assoc()){
				$result_set->close();
				return $row["code"];
			}
			return false;
		}
		
		public static function save($link, $code, $time=""){
			if($time == ""){
				$time = time();
			}
			if(!self::query("INSERT INTO `" . Config::get("database") . "`.`" . Config::get("prefix") . "links` (`url`, `code`, `regtime`) VALUES ('" . $link . "', '" . $code . "', '" . $time . "')")){
				return false;
			}
			return true;
		}
		
		public static function increase($code){
			$views;
			$result_set = self::query("SELECT `views` FROM `" . Config::get("prefix") . "links` WHERE `code`='" . $code . "'");
			if($result_set->num_rows == 0){
				return false;
			}
			elseif($row = $result_set->fetch_assoc()){
				$result_set->close();
				$views = $row["views"];
			}
			if(!self::query("UPDATE `" . Config::get("database") . "`.`" . Config::get("prefix") . "links` SET `views`='" . ($views + 1) . "' WHERE `code`='" . $code . "'")){
				return false;
			}
			return true;
		}
		
		private function __destruct(){
			if(self::$db !== null){
				self::$db->close();
			}
		}
	}
?>