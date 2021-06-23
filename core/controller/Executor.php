<?php

class Executor {

	public static function doit($sql){
		$con = Database::getCon();
		return array($con->query($sql),$con->insert_id);
	}

	public static function do($sql, $db){
		$con = Database::getCon($db);
		return array($con->query($sql),$con->insert_id);
	}
}
?>