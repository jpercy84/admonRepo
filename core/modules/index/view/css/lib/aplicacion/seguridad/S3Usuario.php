<?php

/**
 * Clase que controla la logica del usuario
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class S3Usuario {

    private $id;
    private $nombres;
    private $apellidos;
    private $nombre_completo;
    private $perfilId;
    private $perfil;
    private $administrador;
    private $correo;
    private $dir;
    private $avatar;
    private $cliente_id;
    private $cliente;
    
    public function getId() {
        return $this->id;
    }

    public function getNombreCompleto() {
        return $this->nombre_completo;
    }

    public function getPerfil() {
        return $this->perfil;
    }

    public function getPerfilId() {
        return $this->perfilId;
    }

    public function getAdmin() {
        return $this->administrador;
    }

    public function getNombre() {
        return $this->nombres;
    }

    public function getApellido() {
        return $this->apellidos;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getDir() {
        return $this->dir;
    }
    
    public function getAvatar() {
        return $this->avatar;
    }
    
//    public function getCliente() {
//        return $this->cliente;
//    }
    
//    public function getClienteId() {
//        return $this->cliente_id;
//    }

    public function autenticar($nombreUsuario, $contrasenia) {
        //DB_DataObject::debugLevel(5); 
        global $aplicacion;
        $config = $aplicacion->getConfig();
        
        $this->id = 0;
        $bdUsuario = DB_DataObject::factory('usuario');
        $bdContrasenia = DB_DataObject::factory('contrasenia');


        $bdUsuario->selectAdd();
        $bdUsuario->selectAdd('`usuario`.`id`, `usuario`.`administrador`');

        $bdUsuario->whereAdd('`usuario`.`correo` = "' . $nombreUsuario . '" OR `usuario`.`nombre_usuario`="' . $nombreUsuario . '"');
        $bdUsuario->eliminado = 0;
        $bdContrasenia->hash = sha1(base64_encode(md5($contrasenia) . $config->getVariableConfig('aplicacion-salthash')));
        $bdContrasenia->eliminado = 0;
        $bdUsuario->joinAdd($bdContrasenia);
        $bdUsuario->find();
        $bdUsuario->fetch();

        $this->id = $bdUsuario->id;
    }

    public function cargar() {
        //die('test');
        $session = new S3Session();
        $usuarioId = $session->getVariable('usuario_id');
        $bdUsuario = DB_DataObject::factory('usuario');
        $bdPerfil = DB_DataObject::factory('perfil');

        $bdUsuario->selectAdd();
        $bdUsuario->selectAdd('`usuario`.`id`, `usuario`.`nombre`, `usuario`.`apellido`, `perfil`.`nombre` AS perfil_nombre, `usuario`.`perfil_id`');
        $bdUsuario->selectAdd('`usuario`.`administrador`, `usuario`.`correo`, `usuario`.`cliente_id`');
        $bdUsuario->selectAdd('`usuario`.`uploads_dir`, `usuario`.`avatar`');

        $bdUsuario->id = $usuarioId;

        $bdUsuario->joinAdd($bdPerfil, 'LEFT');

        $bdUsuario->find();
        $bdUsuario->fetch();
		
        $this->id = $bdUsuario->id;
        $this->nombres = $bdUsuario->nombre;
        $this->apellidos = $bdUsuario->apellido;
        $this->nombre_completo = $bdUsuario->nombre . " " . $bdUsuario->apellido;
        $this->administrador = $bdUsuario->administrador;
        $this->perfil = (!empty($bdUsuario->perfil_nombre)) ? $bdUsuario->perfil_nombre : "";
        $this->perfilId = (!empty($bdUsuario->perfil_id)) ? $bdUsuario->perfil_id : "";
        $this->correo = (!empty($bdUsuario->correo)) ? $bdUsuario->correo : "";
        $this->dir = (!empty($bdUsuario->uploads_dir)) ? $bdUsuario->uploads_dir : "";
        $this->avatar = $bdUsuario->avatar;
        $this->cliente = $bdUsuario->cliente_nombre;
        $this->cliente_id = $bdUsuario->cliente_id;
    }

    public function estaAutenticado() {
        return (!empty($this->id)) ? true : false;
    }

    public function desconectar() {
        $session = new S3Session();
        $session->limpiar();
    }

    public function recuperarPassword($usuario) {
        $bdUsuario = DB_DataObject::factory('usuario');

        $bdUsuario->eliminado = 0;
        $bdUsuario->activo = 1;
        $bdUsuario->whereAdd('(`usuario`.`nombre_usuario` = "' . $usuario . '" OR `usuario`.`email` = "' . $usuario . '")');

        $bdUsuario->find();
        $bdUsuario->fetch();

        if ($bdUsuario->id > 0) {
            require_once 'modelo/negocio/objetos/Usuario.php';
            $objUsuario = new Usuario();
            $objUtils = new S3Utils();

            $contrasenia = $objUsuario->crearContrasenia();
            $objUsuario->guardarContrasenia($bdUsuario->id, $contrasenia);
            $objUtils->enviarEmail("Su nueva contraseña es: " . $contrasenia, "Mentero - Recuperacion de password", $bdUsuario->email);

            return true;
        } else {
            return false;
        }
    }

}
