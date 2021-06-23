<?php

/**
 * Clase que encapsulas las funciones generales
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3Utils {

    /**
     * Obtiene el nombre de la clase de negocio a partir del nombre de la tabla (Data Object).
     * @return unknown_type
     */
    public function obtenerClaseNegocioDeDO($nombreDO) {
        $nombreDO = str_replace("_", " ", $nombreDO);
        $nombreDO = ucwords(strtolower($nombreDO));
        $nombreDO = str_replace(" ", "", $nombreDO);
        return $nombreDO;
    }

    /**
     * Se generan thumbnails a partir de un video, debe estar instalado el ffmpeg en el servidor
     * 
     * @param type $rutaVideo
     * @param type $rutaGuardar
     * @param type $tamaño
     * @param type $seg
     */
    public function generarThumbnail($rutaVideo, $rutaGuardar, $tamaño = "100x65", $seg = "00:00:08") {
        $exec = "avconv -i ".$rutaVideo." -s ".$tamaño." -ss ".$seg." -vframes 1 -y ".$rutaGuardar;
        exec($exec);
    }

    public function enviarEmail($mensaje, $titulo, $para) {
        $cabeceras = 'From: no-reply@mentero.co' . "\r\n" .
                'Reply-To: no-reply@mentero.co' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($para, $titulo, $mensaje, $cabeceras);
    }

}
