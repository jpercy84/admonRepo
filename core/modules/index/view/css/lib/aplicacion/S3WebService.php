<?php

/**
 * Clase para el manejo de webservices
 * 
 * @author Brandon Sanchez
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

require_once('lib/aplicacion/requires.php');
require_once('lib/aplicacion/webservice/restful/S3RestUtils.php');

class S3WebService {

    private $estado;
    private $modulo = NULL;
    private $accion = NULL;
    private $xmlOptions = array();

    private function RevisarPermisos($datos) {
        global $aplicacion;
        $perm = false;
        $acc = 'wsobtener';
        $vars = $datos->getRequestVars();

        if (!isset($vars['modulo']) || !isset($vars['usuario']) || !isset($vars['password'])) {
            $perm = false;
        } else {
            $objUsuario = $aplicacion->getUsuario();
            $objUsuario->autenticar($vars['usuario'], $vars['password']);

            include_once 'lib/aplicacion/seguridad/S3ACL.php';
            $objACL = new S3ACL();

            switch ($datos->getMethod()) {
                case 'get':
                    $acc = 'wsobtener';
                    break;
                case 'post':
                    $acc = 'wsasignar';
                    break;
                case 'put':
                    $acc = 'wsactualizar';
                    break;
            }

            $perm = $objACL->verificarPermiso($objUsuario->getId(), $vars['modulo'], $acc);
        }

        return $perm;
    }

    public function procesar() {
        $datos = S3RestUtils::procesarPeticion();
        $vars = $datos->getRequestVars();

        $this->modulo = strtolower($vars['modulo']);
        $this->accion = isset($vars['accion']) ? ucfirst(strtolower($vars['accion'])) : NULL;

        $return_ws = array();
        $perm = $this->RevisarPermisos($datos);

        if ($perm === false || $perm == false || $perm == 0) {
            S3RestUtils::enviarRespuesta(403);
        }

        $this->xmlOptions = array(
            'indent' => '    ',
            'addDecl' => false,
            'rootName' => $this->modulo,
            "defaultTagName" => $this->plural2singular($this->modulo),
            "attributesArray" => "_attributes"
        );

        switch ($datos->getMethod()) {
            case 'get':
                $return_ws = $this->methodGet($this->modulo, $this->accion);
                $this->_get($return_ws, $datos);
                break;
            case 'post':
                $return_ws = $this->methodPost($this->modulo, $this->accion);
                $this->_post($return_ws, $datos);
                break;
            case 'put':
                $return_ws = $this->methodPut($this->modulo, $this->accion);
                $this->_put($return_ws, $datos);
                break;
        }
    }

    private function _post($return_ws, $datos) {
        if ($return_ws['id'] > 0) {
            if ($return_ws['accion'] == 'Crear') {
                S3RestUtils::enviarRespuesta(201, $return_ws, $datos->getHttpAccept(), $this->xmlOptions);
            } else {
                S3RestUtils::enviarRespuesta(200, $return_ws, $datos->getHttpAccept(), $this->xmlOptions);
            }
        } else {
            S3RestUtils::enviarRespuesta(400);
        }
    }

    private function _get($return_ws, $datos) {
        if (is_array($return_ws) && count($return_ws) > 0) {
            S3RestUtils::enviarRespuesta($this->estado, $return_ws, $datos->getHttpAccept(), $this->xmlOptions);
        } else {
            S3RestUtils::enviarRespuesta(204);
        }
    }

    private function plural2singular($texto) {
        if (substr($texto, -2) == 'es') {
            return substr($texto, 0, strlen($texto) - 2);
        } else if (substr($texto, -1) == 's') {
            return substr($texto, 0, strlen($texto) - 1);
        }
    }

    private function methodGet() {
        $datos = array();
        if (file_exists('modulos/' . $this->modulo . '/acciones.php')) {
            include_once 'modulos/' . $this->modulo . '/acciones.php';

            $clsModulo = 'Acciones' . ucfirst($this->modulo);
            $objModulo = new $clsModulo();

            if ($this->accion == NULL) {
                $datos = $objModulo->accionWsobtener();
            } else {
                $accion = 'accion' . $this->accion;
                $datos = $objModulo->$accion();
            }

            $this->estado = 200;
        } else {
            $this->estado = 404;
        }
        return $datos;
    }

    private function methodPost() {
        $datos = array();
        if (file_exists('modulos/' . $this->modulo . '/acciones.php')) {
            include_once 'modulos/' . $this->modulo . '/acciones.php';

            $clsModulo = 'Acciones' . ucfirst($this->modulo);
            $objModulo = new $clsModulo();

            if ($this->accion == NULL) {
                $datos = $objModulo->accionWsasignar();
            } else {
                $accion = 'accion' . $this->accion;
                $datos = $objModulo->$accion();
            }

            $this->estado = 200;
        } else {
            $this->estado = 404;
        }

        return $datos;
    }

    private function methodPut() {
        $datos = array();
        if (file_exists('modulos/' . $this->modulo . '/acciones.php')) {
            require_once 'modulos/' . $this->modulo . '/acciones.php';

            $clsModulo = 'Acciones' . ucfirst($this->modulo);
            $objModulo = new $clsModulo();

            if ($this->accion == NULL) {
                $datos = $objModulo->accionWsactualizar();
            } else {
                $accion = 'accion' . $this->accion;
                $datos = $objModulo->$accion();
            }

            $this->estado = 200;
        } else {
            $this->estado = 404;
        }
        return $datos;
    }

}
