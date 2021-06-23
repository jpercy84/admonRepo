<?php
include_once("./core/modules/index/view/config.php");

class Database {
	public static $db;
	public static $con;
	function Database($db){
		$this->user=user;$this->pass=password;$this->host=host;$this->ddbb=$db;
	}

	function connect(){
		$con = new mysqli($this->host,$this->user,$this->pass,$this->ddbb);
		
		return $con;
		
	}

	public static function getCon($db = "bd_sisben"){
		if(self::$con==null && self::$db==null){
			self::$db = new Database($db);
			self::$con = self::$db->connect();
		}else{
			self::$con->select_db($db);
		}
		return self::$con;
	}
	
}
?>
