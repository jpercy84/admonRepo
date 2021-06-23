<?php

/**
 * Clase que controla lo que tiene que ver con el motor de Template
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3Vista extends Smarty {

    function __construct() {
        global $aplicacion;
        $this->template_dir = 'web/templates/';
        $this->compile_dir = 'cache/smarty/templates_c/';
        $this->config_dir = 'config/smarty/configs/';
        $this->cache_dir = 'cache/smarty/cache/';
        if ($aplicacion->getModoDesarrollo()) {
            $this->debugging = true;
        }
    }

}
