<?php
require_once('lib/aplicacion/seguridad/S3ACL.php');
class TreeNodes {
	private $s3ACL;
	function __construct(){
		$this->s3ACL = new S3ACL();
	} 
	protected $nodes = array();
	
	public function getNodes(){
		return $this->nodes;
	}
	
	function add($nodo) {
		$n = new TreeNode($nodo['id'],$nodo['text'],$nodo['iconCls'],$nodo['leaf'],$nodo['draggable'],$nodo['href'],$nodo['hrefTarget']);
		
		$this->nodes[] = $n;
	}
	
	function toJson() {
		return json_encode($this->nodes);
	}
	
	function findTree($menu, $nodo, &$array = array()){		
	    foreach($menu as $one => $conf){	    	
	        if($one == $nodo){
	            if(isset($conf['hijos']) && count($conf['hijos']) > 0){	            	
	                $array = $this->cleanChildren($conf['hijos']);	                
	            }else{
	                $array = $conf;
	            }
	        }else{
                if(isset($conf['hijos']) && is_array($conf['hijos']) && count($conf['hijos']) > 0){
                    $this->findTree($conf['hijos'], $nodo, $array);
                }
	        }
	    }	    
        return $array;
	}
	
	function cleanChildren($estructura){
	    $childrens = array();	    	   
	    foreach($estructura as $arr => $nodos){	    		    
	    	if($this->tienePermisos($nodos)){	    			   
		        if(isset($estructura[$arr]['hijos']) && is_array($estructura[$arr]['hijos'])){
	                $estructura[$arr]['leaf'] = false;
		            unset($nodos['hijos']);
		        }	        
		        $childrens[] = $estructura[$arr];
	    	}
	    }
	    return $childrens;
	}
	
	function tienePermisos($nodo){
		$tienePermiso = false;
		$this->permisosHijo($nodo, $tienePermiso);
		return $tienePermiso;		
	}
	
	function permisosHijo($nodo, &$tienePermiso){
		$session = new S3Session();
		$usuarioId = $session->getVariable('usuario_id');		
		if(!$tienePermiso){											
			if(isset($nodo['hijos']) && is_array($nodo['hijos']) && count($nodo['hijos']) > 0){
				foreach($nodo['hijos'] as $nodoHijoId=>$nodoHijo){				
					if(!$tienePermiso){												
						$this->permisosHijo($nodoHijo, $tienePermiso);					
					}
				}
			}else{
				if(isset($nodo['acl']) && count($nodo['acl'])>0){
					$nodoACL = $nodo['acl'];
					$tienePermiso = $this->s3ACL->verificarPermiso($usuarioId, $nodoACL['modulo'], $nodoACL['accion']);													
				}
			}
		}						
	}
}
?>