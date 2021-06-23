<?php

/**
 * Clase que controla la session
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3Session {

    public function estaAutenticado() {
        if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] > 0) {
            return true;
        }
        return false;
    }

    public function setVariable($variable, $valor) {
        $_SESSION[$variable] = $valor;
    }

    public function getVariable($variable) {
        if (isset($_SESSION[$variable])) {
            return $_SESSION[$variable];
        } else {
            return NULL;
        }
    }

    public function limpiar() {
        session_unset();
        session_destroy();
    }
}