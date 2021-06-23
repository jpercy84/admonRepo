<?php

/**
 * Clase que controla los permisos de la aplicación
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class S3ACL {

    public function verificarPermiso($usuarioId, $modulo, $accion) {
//		DB_DataObject::debugLevel(5);
        $bdUsuario = DB_DataObject::factory('usuario');
        $bdUsuario->get($usuarioId);

        if (!$bdUsuario->administrador) {

            if ($modulo == 'usuarios' && $accion == 'logout' || $accion == 'editar' ) {
                return true;
            }

            $bdACL = DB_DataObject::factory('acl_perfil_modulo');
            $bdPerfil = DB_DataObject::factory('perfil');
            $bdModulo = DB_DataObject::factory('modulo');
            $bdAccion = DB_DataObject::factory('accion');

            $bdACL->selectAdd();
            $bdACL->selectAdd('COUNT(acl_perfil_modulo.perfil_id) AS tiene_permiso');

            $bdACL->activo = 1;
            $bdPerfil->activo = 1;
            $bdModulo->activo = 1;
            $bdAccion->activo = 1;

            $bdACL->perfil_id = $bdUsuario->perfil_id;

            $bdModulo->nombre = $modulo;
            $bdAccion->nombre = $accion;

            $bdACL->joinAdd($bdPerfil);
            $bdACL->joinAdd($bdModulo);
            $bdACL->joinAdd($bdAccion);

            $bdACL->find();
            $bdACL->fetch();

            return $bdACL->tiene_permiso;
        } else {
            return true;
        }
    }

    public function verificarPermisoSolicitud($usuarioId, $modulo, $accion) {
        return true;

        $accion = strtolower($accion);
        $modulo = strtolower($modulo);

        $moduloInicial = 'usuario';
        $accionInicial = 'home';
        /* switch($accion){
          case 'buscartarjetahabiente': $accion='listar';
          break;
          case 'nuevo': $accion='editar';
          break;
          } */
        //$acciones = array('listar', 'ver', 'editar', 'imprimir', 'activar', 'renovar', 'reponer', 'activacion_masiva', 'agendar', 'eliminar');		
        if ($modulo === $moduloInicial && $accion === $accionInicial) {
            return true;
        } else {
            return $this->verificarPermiso($usuarioId, $modulo, $accion);
        }
    }

}
