<?php

/**
 * Clase que controla la visualización del Menu
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

require_once('lib/aplicacion/TreeNode.php');
require_once('lib/aplicacion/TreeNodes.php');

class S3Menu {

    public function obtenerEstructuraUsuario() {
        global $aplicacion;
        $session = new S3Session();
        $perfil = $aplicacion->getUsuario()->getPerfil();
        $menu = Spyc::YAMLLoad('config/menu.' . $session->getVariable('lang') . '.yml');
        return $menu[$perfil];
    }

}
