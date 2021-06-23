<?php

class UserData {
	public static $tablename = "BAQ_LOGINS";


	public function UserData(){
		$this->email = "";
		$this->password_login = "";
	}


	public function add(){
		$sql = "insert into user (person_id_persona,password,created_at,user_create,change_pass) ";
		$sql .= "value (\"$this->person_id_persona\",\"$this->password\",\"$this->created_at\",\"$this->user_create\",\"$this->change_pass\")";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set control=1,user_delete=\"$this->user_delete\",deleted_at=\"$this->deleted_at\" where person_id_persona=$this->person_id_persona";
		Executor::doit($sql);
	}


	public static function getByIdNumber($id){
		$sql = "select * from ".self::$tablename." where  person_id_persona=$id and control=0";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());
	}
	
	
	public static function getByEmail($email){
		$sql = "select * from ".self::$tablename." where email=\"$email\"";
		$query = Executor::doit($sql);
		
		return Model::one($query[0],new UserData());
	}

	public static function getLogin($user,$password){
        $sql = "select * from ".self::$tablename." where email=\"$user\" and password_login =\"$password\" "; 
		$query = Executor::doit($sql);
        return Model::one($query[0],new UserData());
	}
	
	 

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where control=0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());

	}


}

?>