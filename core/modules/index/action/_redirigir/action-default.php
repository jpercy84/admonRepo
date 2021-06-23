<?php
/**
* @author monica araque gomez
* @Proceso de redirigir vistas.
**/

		if(!empty($_POST)){		
			if ($_POST['opcion']!="" && $_POST['formulario']!=""){
				$formulario=$_POST['formulario'];
				
				//if ($_POST['opcion']==1){
						Core::redir("./?view=".$formulario."&action=null");
				//}
				/* if ($_POST['opcion']==2){
						Core::redir("./?view=insert".$formulario."&action=null");
				}
				 if ($_POST['opcion']==3){
						Core::redir("./?view=tableedit".$formulario."&action=null");
				}
				 if ($_POST['opcion']==4){
						Core::redir("./?view=tabledelete".$formulario."&action=null");
				}*/
			}
		}

//		Core::redir("./");
		//View::render($this,"index",array("meta"=>$meta));
	





?>