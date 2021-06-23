<?php
error_reporting(0);
use \Firebase\JWT\JWT;
include "core/modules/index/model/LogData.php";
include "core/modules/index/model/baqUsers.php";  



  function listar_log() {  
  $log = LogData::getLog(); //CONSULTA DE LOGS
    
         if($log!=null){

                
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
                   "menu" => $log
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                $contador = 1;            
               
            if(count($log)>0):
              $tablelog = '';
              $divtablelog ='';
              $divtablecampo = '';
              $cont = 1;

               
                  foreach($log as $row):

                    if ($row->estado==1) $accion = "Creacion de usuario";
                    if ($row->estado==2) $accion = "Modificación de usuario";
                    if ($row->estado==3) $accion = "Eliminación de usuario";
                    if ($row->estado==4) $accion = "Creación de Perfil";
                    if ($row->estado==5) $accion = "Modificación de Perfil";
                    if ($row->estado==6) $accion = "Eliminación de Perfil";
                    if ($row->estado==7) $accion = "Creación de Repositorio";
                    if ($row->estado==8) $accion = "Consulta de Repos. - Filtros";
                      $id_user = $row->usuario;
                     $nameuser = baqUsers::checkName($id_user);
                     
                     if($row->estado==8)
                     { 

                        $contatable=1;
                        $codigo = $row->codigo;
                        $logtable = LogData::getLogTables($codigo);
                        $div =  '<div id="_demo'.$cont.'" class="collapse">';
                          if($logtable != null):
                              foreach($logtable as $rowtable):

                                  if($contatable==1){

                                      $divtablelog .= "<p></p><p> Tabla: ".$rowtable->tabla."<button type='button' style='text-decoration: underline; border: none;color: blue;background-color: initial;'  id='demo".$cont."' >Detalle</button></p>";

                                  }else{

                                     $divtablecampo .= "<p></p><p> Tabla: ".$rowtable->tabla."</p>";                                    
                                  }

                                  
                                  $codtablelog = $rowtable->codigo;
                                  $logcampo = LogData::getLogCampos($codtablelog);

                                   if($logcampo != null):
                                       foreach($logcampo as $rowcampo):

                                           $divtablecampo .= "<p> Filtro: ".$rowcampo->campo.' '.$rowcampo->filtro.' '.$rowcampo->campodato."</p>";
                                       
                                       endforeach; 
                                   endif;  


                                   $logvista = LogData::getLogVista($codtablelog);

                                   if($logvista != null):
                                       foreach($logvista as $rowvista):

                                           $divtablecampo .= "<p> Campos Vista: ".$rowvista->campovista."</p>";
                                       
                                       endforeach; 
                                   endif;     

                              $contatable++;
                              endforeach;  
                              
                         //$div .= '</div>';     
                          endif;  
                          $cont++;
                      
                     }
                     $div .= $divtablecampo;
                     $div .= '</div>';
                  $tablelog .= '<tr id="cliente'.$contador.'">
                                <td>'.$contador.'</td>
                                <td>'.$nameuser[0].'</td>
                                <td>'.$accion.'</td>
                                <td>'.$row->fecha.'</td>
                                <td>'.$row->registro.$divtablelog.$div.'</td>
                            </tr>';
                             $contador += 1;
                            unset($divtablelog);
                            unset($divtablecampo);
                  endforeach; 

                 
               
              echo json_encode(array("tablelog" => $tablelog)); 
          endif;
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
    
  }





  ?>