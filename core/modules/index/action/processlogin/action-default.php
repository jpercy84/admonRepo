<?php
error_reporting(0);
//equire "vendor/autoload.php";
use \Firebase\JWT\JWT;
include "core/modules/index/model/UserData.php";
/**
 * From baqUseres import getID to save it in the session variables
 */
include "core/modules/index/model/baqUsers.php";


/**
* Proceso de login
**/ 

header("Access-Control-Allow-Origin: *");

header("Content-Type", "application/x-www-form-urlencoded", true);
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if(!empty($_POST)){
	
	$data = json_decode(file_get_contents("php://input"));
	
	if($data->user!=''){
		
    $user = UserData::getLogin($data->user,md5($data->password));
  	$email = $user->email;
         if($user!=null){

			
				$secret_key = "YOUR_SECRET_KEY";
                $issuer_claim = "THE_ISSUER"; // this can be the servername
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                $expire_claim = $issuedat_claim + 60; // expire time in seconds
                $token = array(
                   "iss" => $issuer_claim,
                   "aud" => $audience_claim,
               	   "iat" => $issuedat_claim,
            	   "nbf" => $notbefore_claim,
                   "exp" => $expire_claim,
                   "data" => array(
                   //"id" => $id,
                   //"firstname" => $firstname,
                   //"lastname" => $lastname,
                   "email" => $email
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                //echo 'sds'.$data->user;



                
                Session::set("email",$user->email);
                $idUser = baqUsers::getID($user->email);
                Session::set("ID", $idUser);

				  echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "error" => "",
                "email" => $email,
                "expireAt" => $expire_claim,
            ));
				//$res = json_encode(["exito" => "Falló la consignación de la transacción"]);
				//echo $res;
				//echo 'acaaa'.Session::get("email");
				//Module::loadLayout("index","widget-default");
		
		}else{
			http_response_code(401);
        echo json_encode(array("error" => "Login Fallido.", "password" => $password));

			//Core::alert("Usuario y password no validos");
			//Core::redir("./");
		}
	}else{
		echo json_encode(array("error" => "Login Fallido.", "password" => $password));
    //Core::alert("Datos vacios");
		//Core::redir("./");
	}
}

?>
