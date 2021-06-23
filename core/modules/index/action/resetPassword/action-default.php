<?php
include "core/modules/index/model/baqUsers.php";

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
    $email = $_POST["email"];

    $responseEmail = baqUsers::checkEmail($_POST["email"]);
    if ($responseEmail[0]->num_rows == 0){

        $errorHtml =  '<html lang="es">'.
        '<head>'.
        '   <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />'.
        '   <title>BAQ60 - Restaurar contrase&ntilde;</title>'.
        '   <meta name="description" content="Reset Password">'.
        '   <style type="text/css">'.
        '       a:hover {text-decoration: underline !important;}'.
        '   </style>'.
        '</head>'.
        '<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">'.
        '   <!--100% body table-->'.
        '   <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"'.
        '       style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: \'Open Sans\', sans-serif;">'.
        '       <tr>'.
        '           <td>'.
        '               <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"'.
        '                   align="center" cellpadding="0" cellspacing="0">'.
        '                   <tr>'.
        '                       <td style="height:80px;">&nbsp;</td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="text-align:center;">'.
        '                         <a href="https://190.248.57.39:8888/baq60project/appbaq60" title="logo" target="_blank">'.
        '                           <img width="120" src="core/modules/index/view/images/escudoAlcaldia.png" title="logo" alt="logo">'.
        '                         </a>'.
        '                       </td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="height:20px;">&nbsp;</td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td>'.
        '                           <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"'.
        '                               style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">'.
        '                               <tr>'.
        '                                   <td style="height:40px;">&nbsp;</td>'.
        '                               </tr>'.
        '                               <tr>'.
        '                                   <td style="padding:0 35px;">'.
        '                                       <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Correo electr&oacute;nico <br> no encontrado'.
        '                                           </h1>'.
        '                                       <span'.
        '                                           style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>'.
        '                                       <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">'.
        '                                           El correo electr&oacute;nico que ingresaste no est&aacute; registrado en nuestra base de datos.'.
        '                                           Por favor regresa e ingresa uno valido.'.
        '                                       </p>'.
        '                                       <a href="/?view=resetPassword&page=passwordEmail&action=null"'.
        '                                           style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Regresar'.
        '                                           </a>'.
        '                                   </td>'.
        '                               </tr>'.
        '                               <tr>'.
        '                                   <td style="height:40px;">&nbsp;</td>'.
        '                               </tr>'.
        '                           </table>'.
        '                       </td>'.
        '                   <tr>'.
        '                       <td style="height:20px;">&nbsp;</td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="text-align:center;">'.
        '                           <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>Alcaldia de Barranquilla.</strong></p>'.
        '                       </td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="height:80px;">&nbsp;</td>'.
        '                   </tr>'.
        '               </table>'.
        '           </td>'.
        '       </tr>'.
        '   </table>'.
        '   <!--/100% body table-->'.
        '</body>'.
        '</html>';

        
        $error = $errorHtml;
    }

    if($error!=""){
        echo "<div class='error'>".$error."</div>";
        }else{
        $expFormat = mktime(
        date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
        );
        $expDate = date("Y-m-d H:i:s",$expFormat);
        $key = md5(2418*2+$email);
        $addKey = substr(md5(uniqid(rand(),1)),3,10);
        $key = $key . $addKey;
// Insert Temp Table
        $sqlQuery = "INSERT INTO `BAQ_PASSWORD_RESET` (`email`, `token`, `expDate`)
        VALUES ('".$email."', '".$key."', '".$expDate."');";
        Executor::doit($sqlQuery);

//MAIL MESSAGE 

        $output =  '<html lang="es">'.
        '<head>'.
        '   <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />'.
        '   <title>BAQ60 - Restaurar contrase&ntilde;</title>'.
        '   <meta name="description" content="Reset Password">'.
        '   <style type="text/css">'.
        '       a:hover {text-decoration: underline !important;}'.
        '   </style>'.
        '</head>'.
        '<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">'.
        '   <!--100% body table-->'.
        '   <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"'.
        '       style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: \'Open Sans\', sans-serif;">'.
        '       <tr>'.
        '           <td>'.
        '               <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"'.
        '                   align="center" cellpadding="0" cellspacing="0">'.
        '                   <tr>'.
        '                       <td style="height:80px;">&nbsp;</td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="text-align:center;">'.
        '                         <a href="https://190.248.57.39:8888/baq60project/appbaq60/" title="logo" target="_blank">'.
        '                           <img width="200" style="filter: invert(100%); -webkit-filter: invert(100%);" src="https://www.barranquilla.gov.co/wp-content/themes/barranquilla/assets/img/logo.png" title="logo" alt="logo">'.
        '                         </a>'.
        '                       </td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="height:20px;">&nbsp;</td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td>'.
        '                           <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"'.
        '                               style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">'.
        '                               <tr>'.
        '                                   <td style="height:40px;">&nbsp;</td>'.
        '                               </tr>'.
        '                               <tr>'.
        '                                   <td style="padding:0 35px;">'.
        '                                       <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Querido usuario'.
        '                                           </h1>'.
        '                                       <span'.
        '                                           style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>'.
        '                                       <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">'.
        '                                           Por favor copia este c&oacute;digo <br><b>'. $key .
        '                                           </b><br> en el siguiente link para restaurar tu contrase&ntilde;a'.
        '                                       </p>'.
        '                                       <p>Asegurate de copiar c&oacute;digo completamente. <br> El c&oacute;digo expirar&aacute; en 1 dia por razones de seguridad.<br>'.
        '                                       Si no solicitaste restaurar tu contrase&ntilde;a, omite este correo, tu constrase&ntilde;a continuar&aacute;'.
        '                                       siendo la misma <br> Gracias<br>'.
        '                                       <a href="https://190.248.57.39:8888/?view=resetPassword&page=changePassword&action=null"'.
        '                                           style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Restaurar contrase&ntilde;a'.
        '                                           </a>'.
        '                                   </td>'.
        '                               </tr>'.
        '                               <tr>'.
        '                                   <td style="height:40px;">&nbsp;</td>'.
        '                               </tr>'.
        '                           </table>'.
        '                       </td>'.
        '                   <tr>'.
        '                       <td style="height:20px;">&nbsp;</td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="text-align:center;">'.
        '                           <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>Alcaldia de Barranquilla.</strong></p>'.
        '                       </td>'.
        '                   </tr>'.
        '                   <tr>'.
        '                       <td style="height:80px;">&nbsp;</td>'.
        '                   </tr>'.
        '               </table>'.
        '           </td>'.
        '       </tr>'.
        '   </table>'.
        '   <!--/100% body table-->'.
        '</body>'.
        '</html>';

        $body = $output; 
        $subject = "Restaurar contrasena - Plataforma BAQ60";
        
        $email_to = $email;
        $fromserver = "restorepassword@haana.tech"; 
        require("PHPMailer/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.haana.tech";
        $mail->SMTPAuth = true;
        $mail->SMTPAutoTLS = false; 
        $mail->Username = "restorepassword@haana.tech";
        $mail->Password = "(uW@bVg2";
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->From = "restorepassword@haana.tech";
        $mail->FromName = "Restaurar contrasena BAQ60";
        $mail->Sender = $fromserver;
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($email_to);
        if(!$mail->Send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }else{
            $successPage =  '<html lang="es">'.
            '<head>'.
            '   <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />'.
            '   <title>BAQ60 - Restaurar contrase&ntilde;</title>'.
            '   <meta name="description" content="Reset Password">'.
            '   <style type="text/css">'.
            '       a:hover {text-decoration: underline !important;}'.
            '   </style>'.
            '</head>'.
            '<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">'.
            '   <!--100% body table-->'.
            '   <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"'.
            '       style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: \'Open Sans\', sans-serif;">'.
            '       <tr>'.
            '           <td>'.
            '               <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"'.
            '                   align="center" cellpadding="0" cellspacing="0">'.
            '                   <tr>'.
            '                       <td style="height:80px;">&nbsp;</td>'.
            '                   </tr>'.
            '                   <tr>'.
            '                       <td style="text-align:center;">'.
            '                         <a href="https://190.248.57.39:8888/baq60project/appbaq60/" title="logo" target="_blank">'.
            '                           <img width="120" src="core/modules/index/view/images/escudoAlcaldia.png" title="logo" alt="logo">'.
            '                         </a>'.
            '                       </td>'.
            '                   </tr>'.
            '                   <tr>'.
            '                       <td style="height:20px;">&nbsp;</td>'.
            '                   </tr>'.
            '                   <tr>'.
            '                       <td>'.
            '                           <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"'.
            '                               style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">'.
            '                               <tr>'.
            '                                   <td style="height:40px;">&nbsp;</td>'.
            '                               </tr>'.
            '                               <tr>'.
            '                                   <td style="padding:0 35px;">'.
            '                                       <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Correo enviado satisfactoriamente.'.
        '                                           </h1>'.
             '                                       <a href="http://190.248.57.39:8888/baq60project/appbaq60?view=resetPassword&page=changePassword&action=null"'.
            '                                           style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Volver a inicio'.
        '                                           </a>'.
            '                                   </td>'.
            '                               </tr>'.
            '                               <tr>'.
            '                                   <td style="height:40px;">&nbsp;</td>'.
            '                               </tr>'.
            '                           </table>'.
            '                       </td>'.
            '                   <tr>'.
            '                       <td style="height:20px;">&nbsp;</td>'.
            '                   </tr>'.
            '                   <tr>'.
            '                       <td style="text-align:center;">'.
            '                           <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>Alcaldia de Barranquilla.</strong></p>'.
            '                       </td>'.
            '                   </tr>'.
            '                   <tr>'.
            '                       <td style="height:80px;">&nbsp;</td>'.
            '                   </tr>'.
            '               </table>'.
            '           </td>'.
            '       </tr>'.
            '   </table>'.
            '   <!--/100% body table-->'.
            '</body>'.
            '</html>';
            echo $successPage;
        }
    }
    }
?>