<?php

/**
 * @author $Brandon Sanchez
 * Esta Clase se ejecutara antes de generar la vista, en caso de que
 * sea necesario hacer una validacion antes de mostrar la pagina, ej:
 * validar primer login... asi generar la vista que se debe generar
 */
//error_reporting(1);
if (!defined('s3_entrada')) {
    die('No es un punto de entrada valido');
}


class S3Preformatear {

    public function llamarFunciones() {
        //$this->guardarAuditoria();
        $this->obtenerMenu();
       // $this->cargarCliente();
    }

    private function obtenerMenu() {
        global $aplicacion;
        $menu = new S3Menu();
        $aplicacion->getUsuario()->cargar();

        $aplicacion->getVista()->assign('links_menu', $menu->obtenerEstructuraUsuario());
        if (file_exists('web/templates/aplicacion/menus/' . $aplicacion->getUsuario()->getPerfil() . ".tpl")){
            $aplicacion->getVista()->assign('menu', 'aplicacion/menus/' . $aplicacion->getUsuario()->getPerfil() . ".tpl");
        } else {
            $aplicacion->getVista()->assign('menu', 'aplicacion/menus/default.tpl');
        }
    }

    private function guardarAuditoria() {
        global $aplicacion;
        
        $objRequest = new S3Request();

        $request = $objRequest->obtenerVariables();
        $autenticado = $aplicacion->getSession()->estaAutenticado();

        if ($autenticado && $request['modulo'] != NULL && $request['accion'] != NULL) {
            if ($request['accion'] != 'autenticar' && $request['accion'] != 'login' && $request['accion'] != 'registrar') {
                //require_once 'modelo/negocio/objetos/AuditoriaRegistro.php';
                //$objAuditoriaRegistro = new AuditoriaRegistro();
                //$objAuditoriaRegistro->guardar();
            }
        }
    }
    
    private function cargarCliente() {
        global $aplicacion;
        
        if ($aplicacion->getUsuario()->getPerfilId() == 2) {    
            $bdCliente = DB_DataObject::factory('cliente');
            $bdCliente->get($aplicacion->getUsuario()->getClienteId());
            
            $aplicacion->cliente = $bdCliente->toArray();
        }
    }
    
    private function ultimoRegistro() {
        global $aplicacion;
        $autenticado = $aplicacion->getSession()->estaAutenticado();

        if ($autenticado) {
            require_once 'modelo/negocio/objetos/RegistroIngreso.php';
            $objAuditoriaRegistro = new RegistroIngreso();

            $objAuditoriaRegistro->guardar();
        }
    }

}
