<?php

/**
 * Clase que controla las solicitudes
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3Despachador {

    private $modulo;
    private $accion;
    private $registro;
    private $ajax;

    public function setSolicitud($solicitud) {
        $this->modulo = $solicitud['modulo'];
        $this->accion = $solicitud['accion'];
        $this->registro = $solicitud['registro'];
        $this->ajax = $solicitud['ajax'];
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function getAccion() {
        return (!empty($this->accion)) ? $this->accion : 'listar';
    }

    public function procesarSolicitud() {
        $archivoIncluir = 'modulos/' . strtolower($this->modulo) . '/acciones.php';
        $nomClaseAcciones = 'Acciones' . ucwords(strtolower($this->modulo));
        $nombreAccion = (!empty($this->accion)) ? 'accion' . ucwords(strtolower($this->accion)) : 'accionListar';
        require_once($archivoIncluir);
        $objetoModulo = new $nomClaseAcciones();
        $objetoModulo->$nombreAccion();
    }

}

?>