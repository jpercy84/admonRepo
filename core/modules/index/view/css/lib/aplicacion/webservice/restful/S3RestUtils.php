<?php

/**
 * Clase desarrollada por
 * @author kid_goth
 * 2013 | Soluciones 360 Grados
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

require_once 'lib/aplicacion/webservice/restful/S3RestRequest.php';

class S3RestUtils {

    public static function procesarPeticion() {
        $fv_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        $request_method = strtolower($fv_method);

        $return_obj = new S3RestRequest();
        $datos = array();

        switch ($request_method) {
            case 'get':
                $datos = filter_input_array(INPUT_GET);
                break;
            case 'post':
                $datos = filter_input_array(INPUT_POST);
                break;
            case 'put':
                parse_str(file_get_contents('php://input'), $datos);
                break;
        }

        $return_obj->setMethod($request_method);
        $return_obj->setRequestVars($datos);

        if (isset($datos['data'])) {
            $return_obj->setDatos(json_decode($datos['data']));
        }

        return $return_obj;
    }

    public static function enviarRespuesta($status = 200, $body = array(), $content_type = 'text/html', $options = array()) {
        $estado_header = 'HTTP/1.1 ' . $status . ' ' . S3RestUtils::getMensajeCodigoEstado($status, false, 'en');
        header($estado_header);
        if($content_type != 'text/html') {
            header('Content-type: application/' . $content_type);
        } else {
            header('Content-type: ' . $content_type);
        }

        if (is_array($body) && count($body) > 0 && $content_type != 'text/html') {
            if ($content_type == 'xml') {
                include_once 'lib/includes/PEAR/XML_Serializer/Serializer.php';
                
                $options[XML_SERIALIZER_OPTION_RETURN_RESULT] = true; 
                $XMLs = new XML_Serializer($options);
                echo $XMLs->serialize($body);
            } else if ($content_type == 'json') {
                echo json_encode($body);
            }
            exit;
        } else {
            $mensaje = S3RestUtils::getMensajeCodigoEstado($status, true);
            $signature = 'Server at ' . filter_input(INPUT_SERVER, 'SERVER_NAME') . ' on Port ' . filter_input(INPUT_SERVER, 'SERVER_PORT');

            $body = 'Mensaje de respuesta: "' . $mensaje . '" (' . $signature . ')';

            echo $body;
            exit;
        }
    }

    /**
     * @todo Retorna el mensaje segun el codigo de estado obtenido
     * 
     * @param string $status
     * @return string
     */
    public static function getMensajeCodigoEstado($status, $code = false, $idioma = NULL) {
        global $aplicacion;
        $configLeng = $aplicacion->getConfig()->getVariableConfig('aplicacion-lenguaje');
        $lenguaje = explode('_', $configLeng);
        $mensaje = '';

        $codes = Array(
            100 => array(
                'en' => 'Continue',
                'es' => 'Continuar'
            ),
            101 => array(
                'en' => 'Switching Protocols',
                'es' => 'Cambiando protocolos'
            ),
            200 => array(
                'en' => 'OK',
                'es' => 'OK'
            ),
            201 => array(
                'en' => 'Created',
                'es' => 'Creado'
            ),
            202 => array(
                'en' => 'Accepted',
                'es' => 'Aceptado'
            ),
            203 => array(
                'en' => 'Non-Authoritative Information',
                'es' => 'Informacion no autorizada'
            ),
            204 => array(
                'en' => 'No Content',
                'es' => 'Sin contenido'
            ),
            205 => array(
                'en' => 'Reset Content',
                'es' => 'Contenido reiniciado'
            ),
            206 => array(
                'en' => 'Partial Content',
                'es' => 'Contenido parcial',
            ),
            300 => array(
                'en' => 'Multiple Choices',
                'es' => 'Multiples opciones'
            ),
            301 => array(
                'en' => 'Moved Permanently',
                'es' => 'Movido permanentemente'
            ),
            302 => array(
                'en' => 'Found',
                'es' => 'Encontrado'
            ),
            303 => array(
                'en' => 'See Other',
                'es' => 'Ver otro'
            ),
            304 => array(
                'en' => 'Not Modified',
                'es' => 'No modificado'
            ),
            305 => array(
                'en' => 'Use Proxy',
                'es' => 'Usar proxy'
            ),
            306 => array(
                'en' => '(Unused)',
                'es' => '(No usados)'
            ),
            307 => array(
                'en' => 'Temporary Redirect',
                'es' => 'Redireccion temporal'
            ),
            400 => array(
                'en' => 'Bad Request',
                'es' => 'Mala peticion'
            ),
            401 => array(
                'en' => 'Unauthorized',
                'es' => 'No autorizado'
            ),
            402 => array(
                'en' => 'Payment Required',
                'es' => 'Pago requerido'
            ),
            403 => array(
                'en' => 'Forbidden',
                'es' => 'Prohibido'
            ),
            404 => array(
                'en' => 'Not Found',
                'es' => 'No encontrado'
            ),
            405 => array(
                'en' => 'Method Not Allowed',
                'es' => 'Metodo no permitido'
            ),
            406 => array(
                'en' => 'Not Acceptable',
                'es' => 'No es aceptable'
            ),
            407 => array(
                'en' => 'Proxy Authentication Required',
                'es' => 'Autenticacion proxy requerida'
            ),
            408 => array(
                'en' => 'Request Timeout',
                'es' => 'Tiempo de espera agotado para la solicitud'
            ),
            409 => array(
                'en' => 'Conflict',
                'es' => 'Conflicto'
            ),
            410 => array(
                'en' => 'Gone',
                'es' => 'Ido'
            ),
            411 => array(
                'en' => 'Length Required',
                'es' => 'Tamaño requerido'
            ),
            412 => array(
                'en' => 'Precondition Failed',
                'es' => 'Fallo el prerequisito'
            ),
            413 => array(
                'en' => 'Request Entity Too Large',
                'es' => 'Solicitud demasiado extensa'
            ),
            414 => array(
                'en' => 'Request-URI Too Long',
                'es' => 'Solicitud muy larga'
            ),
            415 => array(
                'en' => 'Unsupported Media Type',
                'es' => 'Tipo de medio no soportado'
            ),
            416 => array(
                'en' => 'Requested Range Not Satisfiable',
                'es' => 'Rango de solicitud no satisfecho'
            ),
            417 => array(
                'en' => 'Expectation Failed',
                'es' => 'Expectativa fallida'
            ),
            500 => array(
                'en' => 'Internal Server Error',
                'es' => 'Error interno del servidor'
            ),
            501 => array(
                'en' => 'Not Implemented',
                'es' => 'No implementado'
            ),
            502 => array(
                'en' => 'Bad Gateway',
                'es' => 'Entrada no valida'
            ),
            503 => array(
                'en' => 'Service Unavailable',
                'es' => 'Servicio no disponible'
            ),
            504 => array(
                'en' => 'Gateway Timeout',
                'es' => 'Tiempo de espera agotado para la entrada'
            ),
            505 => array(
                'en' => 'HTTP Version Not Supported',
                'es' => 'Version HTTP no soportada'
            )
        );

        if ($idioma != NULL) {
            $lenguaje = $idioma;
        } else {
            $lenguaje = $lenguaje[0];
        }

        if (isset($codes[$status])) {
            $mensaje = ($code) ? '[' . $status . '] ' . $codes[$status][$lenguaje] : $codes[$status][$lenguaje];
        }

        return $mensaje;
    }

}
