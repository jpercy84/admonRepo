<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_PERFILES
**/
class PerfilSubmenuData {
	public static $tablename = "BAQ_PERFILES_SUBMENUS";


	public function PerfilSubmenudata(){
		$this->PK_baq_perfiles_submenus = "";
		$this->FK_BAQ_SUBMENUS = "";
		$this->FK_BAQ_PERFILES = "";
		$this->borrado = "";
		$this->fecha_creacion="";
		$this->fecha_actualizacion="";
		$this->fecha_eliminacion="";
		$this->usuario_creacion="";
		$this->usuario_actualizacion="";
		$this->usuario_eliminacion="";
	}



	public function add(){
		$sql = "insert into BAQ_PERFILES_SUBMENUS (FK_BAQ_SUBMENUS, FK_BAQ_PERFILES,borrado,fecha_creacion,usuario_creacion) ";
		$sql .= "value (\"$this->FK_BAQ_SUBMENUS\",\"$this->FK_BAQ_PERFILES\",\"$this->borrado\",\"$this->fecha_creacion\",\"$this->usuario_creacion\")";
		return Executor::doit($sql);
	}

	public function delete(){
		$sql = "update ".self::$tablename." set borrado=1,usuario_eliminacion=\"$this->usuario_eliminacion\",fecha_eliminacion=\"$this->fecha_eliminacion\" where FK_BAQ_SUBMENUS=$this->FK_BAQ_SUBMENUS and FK_BAQ_PERFILES=$this->FK_BAQ_PERFILES";
		Executor::doit($sql);
	}


	public function update($id){
		$sql = "update ".self::$tablename." set FK_BAQ_SUBMENUS=\"$this->FK_BAQ_SUBMENUS\", FK_BAQ_PERFILES=\"$this->FK_BAQ_PERFILES\" where PK_baq_perfiles_submenus=\"$id\"";
		Executor::doit($sql);
	}

	public static function getPerfilSubMenu($idperfil,$idsubmenu){
		$sql = "select bsm.nombre,bsm.ruta,bsm.PK_baq_submenu as idsubmenu,p.nombre as nombreperfil from   BAQ_PERFILES as p 
                 inner join BAQ_PERFILES_SUBMENUS as bp On p.PK_baq_perfiles = bp.FK_BAQ_PERFILES
                inner join BAQ_SUBMENUS as bsm On bp.FK_BAQ_SUBMENUS = bsm.PK_baq_submenu
                inner join BAQ_MENUS as bm On bsm.FK_BAQ_MENUS = bm.PK_baq_menus
                where bsm.PK_baq_submenu=\"$idsubmenu\" and p.PK_baq_perfiles= \"$idperfil\" and bsm.borrado=0 and bm.borrado=0 and bp.borrado=0";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PerfilSubmenuData());
	}

	public static function getPerfilSubmenuNotIn($idperfil,$list){
		$sql = "select bsm.nombre,bsm.ruta,bsm.PK_baq_submenu as idsubmenu,p.nombre as nombreperfil from BAQ_PERFILES as p 
                 inner join BAQ_PERFILES_SUBMENUS as bp On p.PK_baq_perfiles = bp.FK_BAQ_PERFILES
                inner join BAQ_SUBMENUS as bsm On bp.FK_BAQ_SUBMENUS = bsm.PK_baq_submenu
                inner join BAQ_MENUS as bm On bsm.FK_BAQ_MENUS = bm.PK_baq_menus
                where  p.PK_baq_perfiles= \"$idperfil\" and bsm.borrado=0 and bm.borrado=0 and bsm.PK_baq_submenu NOT IN ($list)";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PerfilSubmenuData());
	}
}

?>