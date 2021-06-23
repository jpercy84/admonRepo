<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_PERFILES
**/
class PerfilData {
	public static $tablename = "BAQ_PERFILES";


	public function Perfildata(){
		$this->PK_baq_perfiles = "";
		$this->nombre = "";
		$this->borrado = "";
		$this->fecha_creacion="";
		$this->fecha_actualizacion="";
		$this->fecha_eliminacion="";
		$this->usuario_creacion="";
		$this->usuario_actualizacion="";
		$this->usuario_eliminacion="";
	}


	public function add(){
		$sql = "insert into BAQ_PERFILES (nombre,borrado,fecha_creacion,usuario_creacion) ";
		$sql .= "value (\"$this->nombre\",\"$this->borrado\",\"$this->fecha_creacion\",\"$this->usuario_creacion\")";
		return Executor::doit($sql);
	}

	public function delete(){
		$sql = "update ".self::$tablename." set borrado=1,usuario_eliminacion=\"$this->usuario_eliminacion\",fecha_eliminacion=\"$this->fecha_eliminacion\" where PK_baq_perfiles=\"$this->PK_baq_perfiles\"";
		Executor::doit($sql);
	}


	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\",borrado=\"$this->borrado\",usuario_actualizacion=\"$this->usuario_actualizacion\",fecha_actualizacion=\"$this->fecha_actualizacion\" where PK_baq_perfiles=$this->PK_baq_perfiles";
		Executor::doit($sql);
	}


	
	public static function getPerfilByUser($email){
		$sql = "select bm.nombre,bm.PK_baq_menus as idmenu from  BAQ_USUARIOS as u inner join  BAQ_PERFILES_USUARIOS
                as pu On u.PK_baq_usuarios=pu.FK_BAQ_USUARIOS
                inner join BAQ_PERFILES as p On pu.FK_BAQ_PERFILES = p.PK_baq_perfiles 
                 inner join BAQ_PERFILES_SUBMENUS as bp On p.PK_baq_perfiles = bp.FK_BAQ_PERFILES
                inner join BAQ_SUBMENUS as bsm On bp.FK_BAQ_SUBMENUS = bsm.PK_baq_submenu
                inner join BAQ_MENUS as bm On bsm.FK_BAQ_MENUS = bm.PK_baq_menus
                inner join BAQ_LOGINS as bl On u.PK_baq_usuarios=bl.FK_BAQ_USUARIOS
                where bl.email=\"$email\" and p.borrado=0 and bp.borrado=0 and bm.borrado=0 group by bsm.FK_BAQ_MENUS";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PerfilData());
	}

	public static function getPerfiles($idPerfil){
		$sql = "select bp.PK_baq_perfiles as idperfil,bp.nombre as nombre, bp.fecha_creacion, concat(u.p_nombre,' ',u.p_apellido) as user from ".self::$tablename." as bp  inner join BAQ_USUARIOS as u ON bp.usuario_creacion=u.PK_baq_usuarios  where bp.borrado=0 ";
		if($idPerfil!=''){
			$sql .= " AND PK_baq_perfiles=\"$idPerfil\"";  
		}
		$query = Executor::doit($sql);
		return Model::many($query[0],new PerfilData());
	}


}

?>