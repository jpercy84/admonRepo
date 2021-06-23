<?php

/**
 * Clase que controla las acciones
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class S3Accion {

    protected $modulo;
    protected $accion;
    protected $registro;
    protected $confModulo;
    protected $listaRegistros;
    public $regxpag = 10;

    function __construct() {
        $request = new S3Request();
        $this->modulo = $request->obtenerVariablePGR('modulo');
        $this->accion = $request->obtenerVariablePGR('accion');
        $this->registro = $request->obtenerVariablePGR('registro');

        $this->confModulo = Spyc::YAMLLoad('modulos/' . $this->modulo . '/config.yml');
    }

    public function accionListar() {
        global $aplicacion;
        $listado = new S3Listado($this->confModulo['global']['objetoBD']);
        $scripts = array('lib/includes/bootstrap/datatables/js/jquery.dataTables.js', 'lib/includes/bootstrap/datatables/js/dataTables.bootstrap.js', 'web/js/aplicacion/listar.js', 'lib/includes/bootstrap/js/bootstrap-multiselect.js');
        //   $estilos = array('lib/includes/bootstrap/datatables/css/dataTables.bootstrap.css');
        $estilos = array('lib/includes/bootstrap/datatables/css/dataTables.bootstrap.css', 'lib/includes/bootstrap/datatables/extensions/TableTools/css/dataTables.tableTools.css', 'lib/includes/bootstrap/css/bootstrap-multiselect.css');


        $this->listaRegistros = $listado->obtenerRegistros();
        //$pags = $this->paginacion();

        $columnas = $listado->obtenerColumnas($this->confModulo);
        $campos = $listado->obtenerNombresCampos();

        $filtros = $listado->obtenerFiltrosLista($this->confModulo);
        $aplicacion->getVista()->assign('campos', $campos);
        $aplicacion->getVista()->assign('modulo', $this->modulo);
        $aplicacion->getVista()->assign('configModulo', $this->confModulo);
        $aplicacion->getVista()->assign('columnas', $columnas);
        $aplicacion->getVista()->assign('filtros', $filtros);
        $aplicacion->getVista()->assign('listaRegistros', $this->listaRegistros);
        //$aplicacion->getVista()->assign('pags', $pags);
        $aplicacion->getVista()->assign('scripts', $scripts);
        $aplicacion->getVista()->assign('estilos', $estilos);
        $aplicacion->getVista()->assign('contenidoModulo', 'aplicacion/listar.tpl');
    }

    public function accionAjaxtabla() {
        $listado = new S3Listado($this->confModulo['global']['objetoBD']);
        $datos = $listado->obtenerRegistrosTablaAjax();
        // __P($datos);
        die(json_encode($datos));
    }

    public function paginacion() {
        /** paginacion */
        $regxpag = $this->regxpag; //registros por pagina
        $regs = $this->listaRegistros;

        $totReg = count($regs);
        $totPag = ceil($totReg / $regxpag);
        $mod = $totReg % $regxpag;
        //__P($mod);
        $request = new S3Request();
        $pag = $request->obtenerVariablePGR('pag');
        if (empty($pag)) {
            $pag = 1;
        }

        $inicio = ($pag - 1) * $regxpag;
        $fin = $inicio + ($regxpag - 1);
        $prev = $pag - 1;
        $next = $pag + 1;

        if ($pag == 1 || $pag == 0) {
            $prev = 0;
        }

        if ($pag == $totPag) {
            $next = 0;
            if ($mod != 0) {
                $fin = $inicio + $mod;
            }
        }

        $listaRegistrosxPag = array();
        if (count($this->listaRegistros) > 0) {
            for ($i = $inicio; $i <= $fin; $i++) {
                $listaRegistrosxPag[] = $this->listaRegistros[$i];
                //echo "$i";
            }
        }
        //__P($listaRegistrosxPag);
        $this->listaRegistros = $listaRegistrosxPag;
        $paginacion = array('totReg' => $totReg, 'pag' => $pag, 'first' => '1', 'prev' => $prev, 'next' => $next, 'last' => $totPag);

        return $paginacion;
        /** /paginacion */
    }

    public function accionEditar() {
        global $aplicacion;
        $request = new S3Request();

        $scripts = array('web/js/aplicacion/editar.js', 'lib/includes/bootstrap/js/bootstrap-multiselect.js');
        $estilos = array('lib/includes/bootstrap/css/bootstrap-multiselect.css');
        $ver = new S3Ver($this->confModulo['global']['objetoBD']);
        $registro = $ver->obtenerRegistro($this->registro);

        //   __P($ver);
        $aplicacion->getVista()->assign('registro', $registro);
        $aplicacion->getVista()->assign('configModulo', $this->confModulo);
        $aplicacion->getVista()->assign('scripts', $scripts);
        $aplicacion->getVista()->assign('$estilos', $estilos);
        $aplicacion->getVista()->assign('contenidoModulo', 'aplicacion/editar.tpl');
    }

    public function accionNuevo() {
        global $aplicacion;
        $utils = new S3Utils();
        $request = new S3Request();

        $claseON = $utils->obtenerClaseNegocioDeDO($this->confModulo['global']['objetoBD']);
        require_once('modelo/negocio/objetos/' . $claseON . '.php');
        $objetoNegocio = new $claseON();
        $registro = $objetoNegocio->nuevo();
        $aplicacion->getVista()->assign('registro', $registro);
        $aplicacion->getVista()->assign('configModulo', $this->confModulo);
        $aplicacion->getVista()->display('aplicacion/editar.tpl');
        $perfil = $aplicacion->getUsuario()->getPerfilId();
        if ($perfil > 1 && $this->modulo != 'solicitud' && $this->modulo != 'usuarios') {
            $request->redireccionar(array('modulo' => 'agente', 'accion' => 'home'));
        }
    }

    public function accionVer() {
        global $aplicacion;
        $request = new S3Request();
        $ver = new S3Ver($this->confModulo['global']['objetoBD']);
        $this->registro = $request->obtenerVariablePGR('registro_id');
        $registro = $ver->obtenerRegistro($this->registro);
        $aplicacion->getVista()->assign('registro', $registro);

        $aplicacion->getVista()->assign('configModulo', $this->confModulo);
        $aplicacion->getVista()->assign('contenidoModulo', 'modulos/' . $request->obtenerVariablePGR('modulo') . '/ver.tpl');

        return $registro;
    }

    public function accionObtenerlistado() {
        $listado = new S3Listado($this->confModulo['global']['objetoBD']);
        $listaRegistros = $listado->obtenerRegistrosActivos();
        echo "{" . $this->modulo . ": " . json_encode($listaRegistros) . "}";
    }

    public function accionSubirarchivo() {
        global $aplicacion;
        $lenguajeApp = $aplicacion->getLenguaje()->getLenguajeAplicacion();
        $rutaUploadDir = $aplicacion->getConfig()->getVariableConfig('aplicacion-ruta_directorio_upload');
//		__P($_FILES);
        $nombreArchivo = $_FILES['archivo']['name'];
        $tipoArchivo = $_FILES['archivo']['type'];
        $tamanoArchivo = $_FILES['archivo']['size'];
        $extensionArchivo = substr($nombreArchivo, -3);
        $exito = false;
        if ($extensionArchivo != 'xls') {
            $mensaje = str_replace("[nombreArchivo]", $nombreArchivo, $lenguajeApp['lbl_error_extension_archivo']);
        } else {
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaUploadDir . '/' . $nombreArchivo)) {
                $exito = true;
                $mensaje = str_replace("[nombreArchivo]", $nombreArchivo, $lenguajeApp['lbl_archivo_cargo_correctamente']);
            } else {
                $mensaje = $lenguajeApp['lbl_error_guardar_archivo'];
            }
        }
        echo '{success:true, exito:' . json_encode($exito) . ', mensaje:' . json_encode($mensaje) . ', archivo:' . json_encode($nombreArchivo) . '}';
    }

    public function accionGuardar() {
        $request = new S3Request();
        $utils = new S3Utils();

        $claseON = $utils->obtenerClaseNegocioDeDO($this->confModulo['global']['objetoBD']);
        require_once('modelo/negocio/objetos/' . $claseON . '.php');

        $objetoNegocio = new $claseON();

        $objetoNegocio->guardar();
        //  die('test');
        $peticion = array(
            'modulo' => $this->modulo,
            'accion' => 'listar',
            'registro' => '',
            'ajax' => false,
        );
        $request->redireccionar($peticion);
    }

    public function accionEliminar() {
        $request = new S3Request();
        $utils = new S3Utils();
        // die('test');
        $claseON = $utils->obtenerClaseNegocioDeDO($this->confModulo['global']['objetoBD']);
        require_once('modelo/negocio/objetos/' . $claseON . '.php');
        $objetoNegocio = new $claseON();
        $objetoNegocio->eliminar();
        $peticion = array(
            'modulo' => $this->modulo,
            'accion' => 'listar',
            'registro' => '',
            'ajax' => false,
        );
        $request->redireccionar($peticion);
    }

    public function accionToggleactivar() {
        $request = new S3Request();
        $utils = new S3Utils();
        $claseON = $utils->obtenerClaseNegocioDeDO($this->confModulo['global']['objetoBD']);
        require_once('modelo/negocio/objetos/' . $claseON . '.php');
        $objetoNegocio = new $claseON();
        $objetoNegocio->in_activar();
        $peticion = array(
            'modulo' => $this->modulo,
            'accion' => 'listar',
            'registro' => '',
            'ajax' => false,
        );
        $request->redireccionar($peticion);
    }

    public function accionTimer() {
        $request = new S3Request();

        require_once('modelo/negocio/objetos/RegistroActividadUsuario.php');
        $objetoNegocio = new RegistroActividadUsuario();
        $objetoNegocio->in_activar();
        $peticion = array(
            'modulo' => $this->modulo,
            'accion' => 'listar',
            'registro' => '',
            'ajax' => false,
        );
        $request->redireccionar($peticion);
    }

}
