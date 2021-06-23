<?php


/// en caso de que el parametro action este definido evitamos que se muestre
/// el layout por defecto y ejecutamos el action sin mostrar nada de vista
// print_r($_GET);
if(!isset($_GET["action"])){
	Module::loadLayout("index","index");
}else{
  if(($_GET["action"])!='null'):
	 Action::load($_GET["action"]);
  else:
	Module::setModule("");
	if($_GET["page"]=='null')$_GET["page"]='';
	Module::loadLayout($_GET["view"],$_GET["page"]);
  endif;
}

?>