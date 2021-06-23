<?php

/**
 * Clase que controla la configuracion
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class S3Config {

    private $configApp;

    public function getConfigApp() {
        return $this->configApp;
    }

    public function cargarConfiguracionAplicacion() {
        $this->configApp = Spyc::YAMLLoad('config/config.yml');
    }

    public function getVariableConfig($variable) {
        $ruta = explode("-", $variable);
        $temp = $this->configApp;
        for ($r = 0; $r < count($ruta); $r++) {
            $clave = $ruta[$r];
            $temp = $temp[$clave];
        }
        return $temp;
    }

}
