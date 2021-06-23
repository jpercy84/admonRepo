<?php
/**
* @author Ing. John Percybrooks
* @class SolSisbenData
* @brief Modelo de base de datos para la tabla de solicitud_sisben
**/
class SolSisbenData {
	public static $tablename = "solicitud_sisben";


	public function SolSisbenData(){
		$this->id_solicitud = "";
		$this->radicado = "";
		$this->documento = "";
		$this->primer_nombre ="";
		$this->segundo_nombre ="";
		$this->primer_apellido ="";
		$this->segundo_apellido ="";
		$this->tipo_tramite ="";
		$this->estado_tramite ="";
		$this->observaciones ="";
	}


	public function add(){
		$sql = "insert into solicitud_sisben (radicado,documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,tipo_tramite,estado_tramite,observaciones) ";
		$sql .= "value (\"$this->radicado\",\"$this->documento\",\"$this->primer_nombre\",\"$this->segundo_nombre\",\"$this->primer_apellido\",\"$this->segundo_apellido\",\"$this->tipo_tramite\",\"$this->estado_tramite\",\"$this->observaciones\")";
		//echo $sql;
		return Executor::doit($sql);
	}

	public function delete(){
		$sql = "delete from  ".self::$tablename;
		Executor::doit($sql);
	}


	
	public static function getSolicitudByDocumento($documento){
		$sql = "select * from ".self::$tablename." where documento ='".$documento."'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SolSisbenData());
	}

	public static function getSolicitudByRadicado($radicado){
		$sql = "select * from ".self::$tablename." where radicado ='".$radicado."'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SolSisbenData());
	}


}

?>