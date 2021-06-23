<?php

/**
 * Clase desarrollada por
 * @author kid_goth
 * 2013 | Soluciones 360 Grados
 */
class S3RestRequest {

    private $request_vars;
    private $datos;
    private $http_accept;
    private $metodo;

    public function __construct() {
        $server = filter_input(INPUT_SERVER, 'HTTP_ACCEPT');

        $this->request_vars = array();
        $this->datos = '';
        $this->http_accept = (preg_match("/xml/i", $server)) ? 'xml' : 'json';
        $this->metodo = 'get';
    }

    public function setDatos($datos) {
        $this->datos = $datos;
    }

    public function setMethod($method) {
        $this->metodo = $method;
    }

    public function setRequestVars($request_vars) {
        $this->request_vars = $request_vars;
    }

    public function getData() {
        return $this->datos;
    }

    public function getMethod() {
        return $this->metodo;
    }

    public function getHttpAccept() {
        return $this->http_accept;
    }

    public function getRequestVars() {
        return $this->request_vars;
    }

}
