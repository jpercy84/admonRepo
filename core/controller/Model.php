<?php


// 10 de Octubre del 2014
// Model.php
// @brief agrego la clase Model para reducir las lineas de los modelos

class Model {

	public static function exists($modelname){
		$fullpath = self::getFullpath($modelname);
		$found=false;
		if(file_exists($fullpath)){
			$found = true;
		}
		return $found;
	}

	public static function getFullpath($modelname){
		
	 if(Module::$module=='index'):
		return "core/modules/".Module::$module."/model/".$modelname.".php";
		else:
		return "core/modules/index/model/".$modelname.".php";
     endif;
	}

	public static function many($query,$aclass){
		$cnt = 0;
		$array = array();
      if($query->num_rows>0){
		while($r = $query->fetch_array()){
			$array[$cnt] = new $aclass;
			$cnt2=1;
			foreach ($r as $key => $v) {
				if($cnt2>0 && $cnt2%2==0){ 
					$array[$cnt]->$key = $v;
				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
	   }	
	}
	//////////////////////////////////
	public static function one($query,$aclass){
		$cnt = 0;
		$found = null;
		$data = new $aclass;
	  //echo "hola".$query;
	  if ($query!=null){
		  if($query->num_rows>0){
			 // echo $query->num_rows;
			while($r = $query->fetch_array()){
				$cnt=1;
				foreach ($r as $key => $v) {
					if($cnt>0 && $cnt%2==0){ 
						$data->$key = $v;
					}
					$cnt++;
				}
			 
				$found = $data;
				break;
			}
		   }
	   }
		return $found;		
	}

}



?>