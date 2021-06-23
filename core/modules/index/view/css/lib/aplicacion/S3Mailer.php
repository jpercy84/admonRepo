<?php

/**
 * Clase que encapsula las funciones de envio de correos usando PHPMailer
 * 
 * @author Brandon Sanchez
 *
 */
if (!defined('s3_entrada') || !s3_entrada) {
    die('No es un punto de entrada valido');
}

class S3Mailer {

    private $plantilla;
    private $tpl_base = 'mail.tpl';
    private $datos;
    private $objMailer = NULL;
    
    /**
     * @todo Cargar la configuracion de la conexion SMTP
     * 
     * @global array $aplicacion
     * @param bool $exceptions
     */
    public function __construct($exceptions = false) {
        require_once 'lib/includes/PHPMailer/class.phpmailer.php';
        $this->objMailer = new PHPMailer();

        global $aplicacion;
        $config = $aplicacion->getConfig();
        $smtp_conf = $config->getVariableConfig('aplicacion-smtp');
        
        $this->objMailer->SMTPDebug = 0;
        $this->objMailer->isSMTP();
        $this->objMailer->Host = $smtp_conf['host'];
        $this->objMailer->Port = $smtp_conf['puerto'];
        $this->objMailer->SMTPSecure = $smtp_conf['sec'];
        $this->objMailer->SMTPAuth = true;
        $this->objMailer->isHTML(true);
        $this->objMailer->Username = $smtp_conf['usuario']; 
        $this->objMailer->Password = base64_decode(base64_decode($smtp_conf['contrasenia']));
        $this->objMailer->From = $smtp_conf['from'];
        $this->objMailer->FromName = $smtp_conf['fromName'];
        $this->objMailer->Timeout=$smtp_conf['timeout'];
    }    
    
    
    /**
     * 
     * @global array $aplicacion
     * @param string $receptor
     * @param string $asunto
     */
    public function enviarCorreo($receptor, $asunto) {
        global $aplicacion;
        
        foreach ($this->datos as $key => $dato) {
            $aplicacion->getVista()->assign($key, $dato);
        }
        $aplicacion->getVista()->assign('contenidoMail', $this->plantilla);
        $html = $aplicacion->getVista()->fetch($this->tpl_base);
        
        if (is_array($receptor)) {
            foreach ($receptor as $r) {
                $this->objMailer->addAddress($r);
            }
        } else if (is_string($receptor)) {
            $receptores = explode(',', $receptor);
            foreach ($receptores as $r) {
                $this->objMailer->addAddress($r);
            }
        }
        
        $this->objMailer->Subject = $asunto;        
        $this->objMailer->Body = $html;
        $this->objMailer->msgHTML($html);
        $this->objMailer->AltBody = "";
        
        return $this->objMailer->send();
    }
    
    /**
     * 
     * @param string $plantilla
     */
    public function asignarPlantilla($plantilla) {
        $this->plantilla = $plantilla;
    }
    
    /**
     * 
     * @param string $tpl_base
     */
    public function asignarTplBase($tpl_base) {
        $this->tpl_base = $tpl_base;
    }
    
    /**
     * 
     * @param array $datos
     */
    public function asignarDatos($datos) {
        $this->datos = $datos;
    }

}
