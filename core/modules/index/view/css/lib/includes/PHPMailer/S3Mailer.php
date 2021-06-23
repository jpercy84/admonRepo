<?php

/**
 * Clase desarrollada por
 * @author kid_goth
 * 2013 | Soluciones 360 Grados
 */

require_once 'class.phpmailer.php';

class S3Mailer extends PHPMailer {
    
    public function __construct($exceptions = false) {
        parent::__construct($exceptions);
        global $aplicacion;
        $config = $aplicacion->getConfig();
        $smtp_conf = getVariableConfig('aplicacion-smtp');
        
        echo "<pre>";
        print_r($config);
        die();
        
        $this->Mailer = "smtp";
        $this->Host = $smtp_conf['host'];
        $this->Port = $smtp_conf['puerto'];
        $this->SMTPAuth = true;
        $this->Username = $smtp_conf['usuario']; 
        $this->Password = base64_decode(base64_decode($smtp_conf['contrasenia']));
        $this->From = $smtp_conf['from'];
        $this->FromName = $smtp_conf['fromName'];
        $this->Timeout=$smtp_conf['timeout'];
    }
}
