<?php
/**
* @author Ing. John Percybrooks
* @class MenusDataD
* @brief Modelo de base de datos para la tabla de BAQ_MENUS
**/
class MenusData {
	public static $tablename = "BAQ_MENUS";


	public function Menusdata(){
		$this->PK_baq_menus = "";
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
		$sql = "insert into " . self::$tablename ." (nombre,borrado,fecha_creacion,usuario_creacion) ";
		$sql .= "value (\"$this->nombre\",\"$this->borrado\",\"$this->fecha_creacion\",\"$this->usuario_creacion\")";
		return Executor::doit($sql);
	}

	public function delete($id){
		$sql = "update ".self::$tablename." set borrado=1,usuario_eliminacion=\"$this->usuario_eliminacion\",fecha_eliminacion=\"$this->fecha_eliminacion\" where PK_baq_menus=\"$id\"";
		Executor::doit($sql);
	}


	public function update($id){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\" where PK_baq_menus=\"$id\"";
		Executor::doit($sql);
	}


	
	public static function getMenuByUser($email){
		$sql = "select bm.nombre,bm.PK_baq_menus as idmenu,pu.FK_BAQ_PERFILES as perfil from  BAQ_USUARIOS as u inner join  BAQ_PERFILES_USUARIOS
                as pu On u.PK_baq_usuarios=pu.FK_BAQ_USUARIOS
                inner join BAQ_PERFILES as p On pu.FK_BAQ_PERFILES = p.PK_baq_perfiles 
                inner join BAQ_PERFILES_SUBMENUS as bp On p.PK_baq_perfiles = bp.FK_BAQ_PERFILES
                inner join BAQ_SUBMENUS as bsm On bp.FK_BAQ_SUBMENUS = bsm.PK_baq_submenu
                inner join BAQ_MENUS as bm On bsm.FK_BAQ_MENUS = bm.PK_baq_menus
                inner join BAQ_LOGINS as bl On u.PK_baq_usuarios=bl.FK_BAQ_USUARIOS
                where bl.email=\"$email\" and bm.borrado=0 and bsm.borrado=0 group by bsm.FK_BAQ_MENUS";
		$query = Executor::doit($sql);
		return Model::many($query[0],new MenusData());
	
	}

	public static function getMenuByPerfil($idperfil){
		$sql = "select bm.nombre,bm.PK_baq_menus as idmenu,p.nombre as nombreperfil  from  
                 BAQ_PERFILES as p 
                 inner join BAQ_PERFILES_SUBMENUS as bp On p.PK_baq_perfiles = bp.FK_BAQ_PERFILES
                 inner join BAQ_SUBMENUS as bsm On bp.FK_BAQ_SUBMENUS = bsm.PK_baq_submenu
                 inner join BAQ_MENUS as bm On bsm.FK_BAQ_MENUS = bm.PK_baq_menus
                 where p.PK_baq_perfiles=\"$idperfil\" and bm.borrado=0 and bsm.borrado=0 group by bsm.FK_BAQ_MENUS";
		$query = Executor::doit($sql);
		return Model::many($query[0],new MenusData());
	}

	public static function getMenu(){
		$sql = "select bm.nombre,bm.PK_baq_menus as idmenu,bm.fecha_creacion,bm.usuario_creacion from  ".self::$tablename." as bm 
                where  bm.borrado=0 ";

		$query = Executor::doit($sql);
		return Model::many($query[0],new MenusData());
	}

	public static function getMenuById($idme){
		$sql = "select bm.nombre,bm.PK_baq_menus as idmenu,bm.fecha_creacion,bm.usuario_creacion from  ".self::$tablename." as bm 
                where  bm.PK_baq_menus=\"$idme\" and   bm.borrado=0 ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new MenusData());
	}


}

?>