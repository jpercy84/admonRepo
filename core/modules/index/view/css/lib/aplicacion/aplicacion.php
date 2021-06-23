<?php

/**
 * El controlador Principal
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada')) {
    die('No es un punto de entrada valido');
}

class Aplicacion {

    private $solicitud;
    private $ambiente;
    private $modoDesarrollo;
    private $config;
    private $errorGlobal;
    private $session;
    private $lenguaje;
    private $bd;
    private $usuario;
    private $vista;
    private $acl;

    public function setAmbiente($ambiente) {
        $this->ambiente = $ambiente;
    }

    public function getModoDesarrollo() {
        return $this->modoDesarrollo;
    }

    public function getACL() {
        return $this->acl;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getConfig() {
        return $this->config;
    }

    public function getBD() {
        return $this->bd;
    }

    public function getLenguaje() {
        return $this->lenguaje;
    }

    public function getSession() {
        return $this->session;
    }

    public function getSolicitud() {
        return $this->solicitud;
    }

    public function getVista() {
        return $this->vista;
    }

    /**
     * Se configura los distintos ambientes de la aplicacion
     * @return unknown_type
     */
    private function configurarAmbiente() {
        if ($this->ambiente == 'dev') {
            $this->modoDesarrollo = true;
        }
    }

    /**
     * REalizar todas las configuraciones iniciales de la aplicacion
     * @return unknown_type
     */
    public function iniciar() {
        require_once('lib/aplicacion/requires.php');
        ini_set("memory_limit", "516M");
        ini_set("max_execution_time", "99999");
        $this->session = new S3Session();
        $this->config = new S3Config();
        $this->error = new S3Error();
        $this->lenguaje = new S3Lenguaje();
        $this->bd = new S3BD();
        $this->vista = new S3Vista();
        $request = new S3Request();
        $this->usuario = new S3Usuario();
        $this->acl = new S3ACL();

        $this->config->cargarConfiguracionAplicacion();
        $this->bd->conectar($this->config->getVariableConfig('aplicacion-bd'));

        $this->configurarAmbiente();
        $this->solicitud = $request->obtenerPeticion();

        switch (strtolower($request->obtenerVariablePGR('lang'))) {
            case 'es':
                $this->session->setVariable('lang', 'es_CO');
                break;
            case 'en':
                $this->session->setVariable('lang', 'en_CO');
                break;
        }

        $this->lenguaje->setLenguaje(($this->session->getVariable('lang') == NULL) ? 'es_CO' : $this->session->getVariable('lang'));
        if (!$this->session->estaAutenticado() && $this->solicitud['modulo'] != 'usuarios' &&
                $this->solicitud['accion'] != 'autenticar') {

            $this->solicitud = array(
                'modulo' => 'usuarios',
                'accion' => 'login',
                'registro' => '',
                'ajax' => false,
            );
        }

        $preformat = new S3Preformatear();
        $preformat->llamarFunciones();
    }

    /**
     * Procesa la funcion
     * @return unknown_type
     */
    public function procesar() {
        $this->vista->assign('L_APP', $this->lenguaje->getLenguajeAplicacion());
        $this->vista->assign('L_MOD', $this->lenguaje->getLenguajeModulo($this->solicitud['modulo']));
        if ($this->session->estaAutenticado()) {
            $this->usuario->cargar();
            $this->vista->assign('usuario', $this->usuario);
        }
        if (is_array($this->solicitud)) {
            $despachador = new S3Despachador();
            $despachador->setSolicitud($this->solicitud);
            $this->vista->assign('modulo', $despachador->getModulo());
            $this->vista->assign('accion', $despachador->getAccion());
            $this->verificarAccionModulo($despachador->getAccion(), $despachador->getModulo());

            if ($this->acl->verificarPermiso($this->usuario->getId(), $despachador->getModulo(), $despachador->getAccion())) {
                $despachador->procesarSolicitud();
            } else {

                if ($this->solicitud['ajax'] == false) {
                    echo '<script> if(confirm("No tienes permisos para ' . $this->solicitud['accion'] . ', deseas regresar al Home?")) {
                                window.location.assign("index.php")
                            }</script>';
                    __P($this->solicitud, false);
                    die('sin permisos');
                } else {
                    die('sin permisos');
                }
            }
        } else {
            $this->setErrorGlobal('No hay solicitud');
        }

        if ($this->solicitud['ajax'] == false) {
            $this->vista->assign('title', $this->config->getVariableConfig('aplicacion-titulo'));
            $this->vista->assign('erroresGlobales', $this->error->getErroresGlobales());
            if ($this->session->estaAutenticado()) {
                $allvars = json_encode($this->vista->get_template_vars());

                $this->vista->assign('S3VARS', $allvars);
                $tpl = 'web/templates/' . $this->getUsuario()->getPerfil() . '.tpl';
                if (file_exists($tpl)) {
                    $this->vista->display($tpl);
                } else {
                    $this->vista->display('index.tpl');
                }
            } else {
                $this->vista->display('login.tpl');
            }
        }
    }

    /**
     * Finaliza la aplicacion cerrando conexiones,etc
     * @return unknown_type
     */
    public function finalizar() {
        
    }

    public function setErrorGlobal($error) {
        $this->error->agregarError($error);
    }

    private function verificarAccionModulo($accion, $modulo) {
//            DB_DataObject::debugLevel(5);

        if (!empty($accion)) {
            $bdObjeto = DB_DataObject::factory('accion');
            $bdObjeto->selectAdd('COUNT(id) as c');
            $bdObjeto->nombre = $accion;
            $bdObjeto->find();
            $bdObjeto->fetch();

            if ($bdObjeto->c == 0) {
                $bdAccion = DB_DataObject::factory('accion');
                $bdAccion->nombre = $accion;
                $bdAccion->insert();
            }
        }
        if (!empty($modulo)) {

            $bdObjeto = DB_DataObject::factory('modulo');
            $bdObjeto->selectAdd('COUNT(id) as c');
            $bdObjeto->nombre = $modulo;
            $bdObjeto->find();
            $bdObjeto->fetch();

            if ($bdObjeto->c == 0) {
                $bdAccion = DB_DataObject::factory('modulo');
                $bdAccion->nombre = $modulo;
                $bdAccion->insert();
            }
        }
    }

}
