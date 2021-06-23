<?php

/**
 * Clase que controla los listados
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3Listado {

    private $objetoBD;
    private $objetoNegocio;

    public function __construct($objeto) {
        $this->objetoBD = $objeto;
        $utils = new S3Utils();
        $claseON = $utils->obtenerClaseNegocioDeDO($this->objetoBD);
        require_once('modelo/negocio/objetos/' . $claseON . '.php');
        $this->objetoNegocio = new $claseON();
    }

    public function obtenerRegistros() {
        return $this->objetoNegocio->obtenerListaRegistros();
    }

    public function obtenerRegistrosActivos() {
        return $this->objetoNegocio->obtenerListaRegistros(true);
    }

    public function obtenerRegistrosTablaAjax() {
        return $this->objetoNegocio->obtenerListaRegistros(false, true);
    }

    public function obtenerNombresCampos() {
        return $this->objetoNegocio->obtenerCamposListado();
    }

    public function obtenerColumnas($configModulo) {
        global $aplicacion;
        $columnas = array();
        $campos = $this->obtenerNombresCamposLista($configModulo);
        $solicitud = $aplicacion->getSolicitud();
        $lenguajeModulo = $aplicacion->getLenguaje()->getLenguajeModulo($solicitud['modulo']);
        for ($c = 0; $c < count($campos); $c++) {
            $nombreEtiqueta = 'lbl_lista_' . $campos[$c];
            $etiquetaCampo = (array_key_exists($nombreEtiqueta, $lenguajeModulo)) ? $lenguajeModulo[$nombreEtiqueta] : $campos[$c];
            $columnas[] = array(
                'id' => $campos[$c],
                'header' => $etiquetaCampo,
                'sortable' => true,
                'dataIndex' => $campos[$c],
            );
        }
        return $columnas;
    }

    public function obtenerNombresCamposLista($configModulo) {
        if (isset($configModulo['lista']['campos']) && count($configModulo['lista']['campos']) > 0) {
            return $configModulo['lista']['campos'];
        } else {
            return $this->obtenerNombresCampos();
        }
    }

    public function obtenerFiltrosLista($configModulo) {
        $filtros = array();
        if (isset($configModulo['lista']['filtros']) && count($configModulo['lista']['filtros']) > 0) {
            foreach ($configModulo['lista']['filtros'] as $campo => $tipoFiltro) {
                $filtros[] = array(
                    'dataIndex' => $campo,
                    'type' => $tipoFiltro
                );
            }
        }
        return $filtros;
    }

}

?>