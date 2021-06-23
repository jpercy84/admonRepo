<?php

/**
 * Clase que controla el idioma 
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3Lenguaje {

    private $lenguaje;

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function getLenguajeAplicacion() {
        $lenguajeAplicacion = Spyc::YAMLLoad('lenguaje/lenguaje.' . $this->lenguaje . '.yml');
        return $lenguajeAplicacion;
    }

    /**
     * Obtiene las etiquetas segun el modulo ingresado
     * @param $modulo
     * @return unknown_type
     */
    public function getLenguajeModulo($modulo) {
        $tmplenguajeModulo = Spyc::YAMLLoad('modulos/' . $modulo . '/lenguaje/lenguaje.' . $this->lenguaje . '.yml');
        $lenguajeModulo = array();
        
        foreach($tmplenguajeModulo as $key => $val) {
            $lenguajeModulo[$key] = preg_replace("/(\d\w\s)*\*$/", '<span class="text-danger">*</span>', $val);
        }
        
        return $lenguajeModulo;
    }
}