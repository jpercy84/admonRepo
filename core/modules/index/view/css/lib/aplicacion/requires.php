<?php
//Includes
//Smarty
define('SMARTY_DIR',str_replace("\\","/",getcwd()).'/lib/includes/Smarty/libs/');
require_once(SMARTY_DIR . 'Smarty.class.php');

//spyc
require_once('lib/includes/spyc/spyc.php');

//Pear
ini_set('include_path', '.'.PATH_SEPARATOR .'lib/includes/PEAR/');

require_once('PEAR.php');
require_once('DB/DataObject.php');

//Aplicacion
require_once('lib/aplicacion/comunes.php');
require_once('lib/aplicacion/S3Request.php');
require_once('lib/aplicacion/S3Session.php');
require_once('lib/aplicacion/S3Vista.php');
require_once('lib/aplicacion/S3Config.php');
require_once('lib/aplicacion/S3Error.php');
require_once('lib/aplicacion/S3Despachador.php');
require_once('lib/aplicacion/S3Lenguaje.php');
require_once('lib/aplicacion/S3BD.php');
require_once('lib/aplicacion/acciones/S3Accion.php');
require_once('lib/aplicacion/acciones/S3Listado.php');
require_once('lib/aplicacion/acciones/S3Ver.php');
require_once('lib/aplicacion/S3Utils.php');
require_once('lib/aplicacion/S3TablaBD.php');
require_once('lib/aplicacion/S3Menu.php');
require_once('lib/aplicacion/S3Tiempo.php');
require_once('lib/aplicacion/S3Upload.php');
require_once('lib/aplicacion/S3Mailer.php');

//Aplicacion-Seguridad
require_once('lib/aplicacion/seguridad/S3Usuario.php');
require_once('lib/aplicacion/seguridad/S3ACL.php');
require_once('lib/aplicacion/S3Preformatear.php');