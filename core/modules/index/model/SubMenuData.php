<?php
/**
* @author Ing. John Percybrooks
* @class SubMenuData
* @brief Modelo de base de datos para la tabla de BAQ_MENUS
**/
class SubMenuData {
	public static $tablename = "BAQ_SUBMENUS";

	public function SubMenudata(){
		$this->PK_baq_submenu = "";
		$this->FK_BAQ_MENUS_BAQ_SUBMENUS_baq_menus = "";
		$this->nombre = "";
		$this->ruta = "";
		$this->icono = "";
		$this->borrado = "";
		$this->fecha_creacion = "";
		$this->fecha_actualizacion = "";
		$this->fecha_borrado = "";
		$this->fecha_eliminacion = "";
	}


	public function add(){
		$sql = "insert into BAQ_SUBMENUS (nombre,ruta,icono,borrado,fecha_creacion,usuario_creacion) ";
		$sql .= "value (\"$this->nombre\",\"$this->ruta\",\"$this-icono\",\"$this->borrado\",\"$this->fecha_creacion\",\"$this->usuario_creacion\")";
		return Executor::doit($sql);
	}

	public function delete($id){
		$sql = "update ".self::$tablename." set borrado=1,usuario_eliminacion=\"$this->usuario_eliminacion\",fecha_eliminacion=\"$this->fecha_eliminacion\" where PK_baq_submenu=\"$id\"";
		Executor::doit($sql);
	}


	public function update($id){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\" where PK_baq_submenu=\"$id\"";
		Executor::doit($sql);
	}

	public static function getSubMenuByMenu($menu){
          $sql = "select bsm.nombre,bsm.ruta,bsm.PK_baq_submenu as idsubmenu from  
                 BAQ_SUBMENUS as bsm 
                inner join BAQ_MENUS as bm On bsm.FK_BAQ_MENUS = bm.PK_baq_menus
                where  bsm.borrado=0 and bm.borrado=0";
                if($menu!='') $sql .= " and bm.PK_baq_menus=\"$menu\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SubMenuData());
	}

	public static function getSubMenuByPerfil($menu,$perfil){
          $sql = "select bsm.nombre,bsm.ruta,bsm.PK_baq_submenu as idsubmenu from  
                 BAQ_SUBMENUS as bsm 
                inner join BAQ_MENUS as bm On bsm.FK_BAQ_MENUS = bm.PK_baq_menus
                inner join BAQ_PERFILES_SUBMENUS as psm On psm.FK_BAQ_SUBMENUS=bsm.PK_baq_submenu
                where  bsm.borrado=0 and psm.FK_BAQ_PERFILES=\"$perfil\" and bm.borrado=0 and psm.borrado=0";
                if($menu!='') $sql .= " and bm.PK_baq_menus=\"$menu\"";
                $sql .= " Order by bsm.nombre";

		$query = Executor::doit($sql);
		return Model::many($query[0],new SubMenuData());
	}
}

?>