<?php


// 13 de Abril del 2014
// Module.php
// @brief tareas que se realizan con modulos.

class Module {
	public static $module;
	public static $view;
	public static $message;
	
	public static function setModule($module){
		self::$module = $module;		
	}

		
		
	public static function loadLayout($page,$pagina){
	//$page = "processlogin";		

	if(Module::$module=='index'):
		include "core/modules/".Module::$module."/view/layout.php";
        

	else:
        if($page=='index'){
          include "core/modules/index/action/$page/$pagina".".php";	
        }else{
         include "core/modules/index/view/$page/$pagina".".php";	
        }
		
		
		
    endif;
	}

	// validacion del modulo
	public static function isValid(){
		$valid = false;
		$folder = "core/modules/".Module::$module;
		
			if(is_dir($folder)){
				$valid=true;

			}else { self::$message= "<b>404 NOT FOUND</b> Module <b>".Module::$module."</b> folder  !!"; }
		
	
		return $valid;
	}

	public static function Error(){
		echo self::$message;
		die();
	}

}



?>