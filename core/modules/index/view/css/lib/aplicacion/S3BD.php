<?php

/**
 * Clase que controla las peticiones de parte del cliente.
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3BD {

    public function conectar($configuracion) {
        $dns = 'mysql://'.$configuracion['usuario'].':'.$configuracion['contrasenia'].'@'.$configuracion['servidor'].':'.$configuracion['puerto'].'/'.$configuracion['nombre_bd'];
        /*$dns = array(
            'phptype' => 'mysql',
            'username' => $configuracion['usuario'],
            'password' => $configuracion['contrasenia'],
            'hostname' => $configuracion['servidor'],
            'port' => 3306,
            'database' => $configuracion['nombre_bd'],
            'charset' => 'utf8'
        );*/

        $options = &PEAR::getStaticProperty('DB_DataObject', 'options');
        $options = array(
            'database' => $dns,
            'schema_location' => 'modelo/DataObjects',
            'class_location' => 'modelo/DataObjects',
            'require_prefix' => 'DataObjects/',
            'class_prefix' => 'DataObjects_',
            'quote_identifiers' => true
        );
        $bdUsuario = DB_DataObject::factory('usuario');
        $bdUsuario->query('SET NAMES "utf8"');
    }

    /**
     * Metodo que activa el depurador. Utiliza el depurador de DataObject
     * @param object $nivel
     * @return 
     */
    public function depurar($nivel) {
        DB_DataObject::debugLevel($nivel);
    }

    /**
     * Metodo que devuelve un objecto utilizando la tabla que le entra como parametro
     * @param object $nombreTabla
     * @return 
     */
    public function obtenerObjeto($nombreTabla) {
        $objetoBD = DB_DataObject::factory($nombreTabla);
        return $objetoBD;
    }

}

?>