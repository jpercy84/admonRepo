<?php

/**
 * Clase que controla las peticiones de parte del cliente.
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class S3Request {

    public function obtenerPeticion() {
        global $aplicacion;
        $config = $aplicacion->getConfig()->getConfigApp();
        $modulo = $this->obtenerVariablePGR('modulo');
        $accion = $this->obtenerVariablePGR('accion');

        if (empty($modulo)) {
            $modulo = $config['aplicacion']['modulo_predeterminado'];
            $accion = $config['aplicacion']['accion_predeterminado'];
        }

        return array(
            'modulo' => $modulo,
            'accion' => $accion,
            'registro' => $this->obtenerVariablePGR('registro'),
            'ajax' => $this->obtenerVariablePGR('ajax'),
        );
    }

    public function obtenerVariablePGR($variable) {
        $variablePGR = "";
        if (isset($_REQUEST[$variable]) && !empty($_REQUEST[$variable])) {
            $variablePGR = $_REQUEST[$variable];
        }

        if (isset($_GET[$variable]) && !empty($_GET[$variable])) {
            $variablePGR = $_GET[$variable];
        }

        if (isset($_POST[$variable]) && !empty($_POST[$variable])) {
            $variablePGR = $_POST[$variable];
        }

        return $variablePGR;
    }

    public function obtenerVariables() {
        if (count($_POST)) {
            return $_POST;
        } elseif (count($_REQUEST)) {
            return $_REQUEST;
        }
    }

    public function redireccionar($peticion) {
        /* if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "" && $peticion['accion'] != "ver") {
          $url = $_SERVER['HTTP_REFERER'];
          } else { */
        $urlParametros = "";
        if (isset($peticion['parametros']) && !empty($peticion['parametros'])) {
            foreach ($peticion['parametros'] as $parametroId => $parametro) {
                $urlParametros .= "&$parametroId=$parametro";
            }
        }
        $url = 'index.php?modulo=' . $peticion['modulo'] . '&accion=' . $peticion['accion'] . $urlParametros;
        //}
        header("Location: $url");
        die();
    }

}
