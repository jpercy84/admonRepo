<?php

use \Firebase\JWT\JWT;
include "core/modules/index/model/MenusData.php";
include "core/modules/index/model/SubMenuData.php";
//include "core/modules/index/model/PerfilSubmenuData.php";  



  function listar_menu($idmn) {  

    if($idmn=='')$menu = MenusData::getMenu();

    if($idmn!='')$menu = MenusData::getMenuById($idmn);
    //var_dump($menu);
    
         if($menu!=null){

                
                $secret_key = "YOUR_SECRET_KEYS";
                $issuer_claim = "THE_ISSUERR"; // this can be the servername
                $audience_claim = "THE_AUDIENCEC";
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
                   "menu" => $menu
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                           
            
            if(count($menu)>0):
              $table = '';
              if($idmn==''){ //Mostrar Todos los perfiles
                        
                  foreach($menu as $row):

                  $table .= '<tr id="cliente'.$row->idmenu.'">
                                <td>'.$row->idmenu.'</td>
                                <td>'.$row->nombre.'</td>
                                <td><button value="Consultar" title="Consultar" onclick="ver_menu('.$row->idmenu.')" class="btn btn-primary">
                                <i class="fa fa-search-plus"></i></button>&nbsp;
                                <button value="Actualizar" title="Actualizar" onclick="actualizar_menu('.$row->idmenu.')"  class="btn btn-default"><i class="fa fa-edit">
                                </i></button>&nbsp;<button value="Eliminar" onclick="eliminar_menu('.$row->idmenu.')" title="Actualizar" class="btn btn-danger">
                                <i class="fa fa-trash"></i></button>
                                </td>
                            </tr>';
                  endforeach;  
                  
              }else{   ////Mostrar el detalle de un Perfil
                  foreach($menu as $row):
                    //echo 'acaa'.$idmn;
                   $table  .= '<table id="datatable-perfil" class="table table-responsive" style="width:100%">
                  
                      <tr height="30">
                         
                        <td width="18%"><b>Id Menú</b></td>
                        <td width="81%" colspan="2">'.$row->idmenu.'</td>
                        </tr>
                      <tr height="30">
                         
                        <td width="18%"><b>Nombre</b></td>
                          <td width="81%" colspan="2">'.$row->nombre.'</td>
                        </tr>
                      <tr height="30">
                          
                        <td width="18%"><b>Usuario Creación</b></td>
                          <td width="81%" colspan="2">'.$row->usuario_creacion.'</td>
                        </tr>
                      <tr /height="30">
                        
                        <td><b>Fecha Creación</b></td>
                        <td colspan="2">'.$row->fecha_creacion.'</td>
                       </tr>
                     </table>';
                 endforeach; 
              }   
              echo json_encode(array("table" => $table)); 
          endif;
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron menus registrados"));

    }
  }


  function listar_submenu() {  
          $idsub = '';
          $submenu = SubMenuData::getSubMenuByMenu($idsub); 
          if($submenu!=null){
                //echo json_encode(array("message" => "Login failed.".$email.$tipo));
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
                   "menu" => $submenu
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
           
            if(count($submenu)>0):

               

               //if($tipo == "menu" ){
                
                    $table =  '<div class="list-group">
                            <table class="table">
                            <tr>
                            <th>Id</th>
                            <th>Opci&oacute;n SubMenu</th>
                            <th>Acceso</th>
                            </tr>';
                            //foreach($menu as $row):
                              //$nombreperfil = $row->nombreperfil;
                              //$submenu = SubMenuData::getSubMenuByMenu($row->idmenu);  
                              //$tablemenu .= '<tr><td colspan="3"><b>'.$row->nombre.'</b></td></tr>';
                              foreach($submenu as $rowsubmenu):
                                $table .= '<tr><td>'.$rowsubmenu->idsubmenu.'</td>
                                    <td>'.$rowsubmenu->nombre.'</td>
                                    <td><label class="switch"><input type="checkbox" name="optionp[]" id="optionp" value="'.$rowsubmenu->idsubmenu.'"  /><div class="slider round"></div></label></td></tr>';

                              endforeach;                      
                            //endforeach;
                    $table .= '</table>';    
                    echo json_encode(array("table" => $table));

               
               //}

               
               

            
             
            endif;
      }else{
      http_response_code(401);
        echo json_encode(array("message" => "Login failed."));

    }


 }



  function ingresar_perfil($objperfil) {  

    //$perfil = PerfilData::add($objperfil->nombre,);
    
         if($objperfil!=null){

                
               $perfil = new PerfilData();
               $perfil->nombre = $objperfil->perfil;
               $perfil->borrado = 0;
               $perfil->fecha_creacion = date('Y-m-d H:m:i');
               $perfil->usuario_creacion = 1;
          
          
               $u = $perfil->add();
               $idperfil = $u[1];
               
               foreach ($objperfil->opcionmenu as $clave => $valor) :
                     $perfil = new PerfilSubmenuData();
                     $perfil->FK_BAQ_SUBMENUS = $valor;
                     $perfil->FK_BAQ_PERFILES = $idperfil;
                     $perfil->borrado = 0;
                     $perfil->fecha_creacion = date('Y-m-d H:m:i');
                     $perfil->usuario_creacion = Session::get("ID");
                     $u = $perfil->add();
               endforeach;


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
                   "menu" => $perfil
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                               
               

            
                
              echo json_encode(array("exito" => "guardado")); 
        
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
  }


function modificar_perfil($objperfil) {  

    
         if($objperfil!=null){

                
               $perfil = new PerfilData();
               $perfil->PK_baq_perfiles = $objperfil->idperfil;
               $perfil->nombre = $objperfil->perfil;
               $perfil->borrado = 0;
               $perfil->fecha_actualizacion = date('Y-m-d H:m:i');
               $perfil->usuario_actualizacion = 1;
          
          
               $u = $perfil->update();
               
               $list ="\"\"";
                foreach ($objperfil->opcionmenu as $clave => $valor) :
                   //echo '<p>', htmlspecialchars( $valor), '</p>', PHP_EOL;
                   $menuperfil = PerfilSubmenuData::getPerfilSubMenu($objperfil->idperfil,$valor); 
                   if(!$menuperfil)
                   {
                       //echo json_encode(array("exito" => " nooooo guardado")); 
                       $perfil = new PerfilSubmenuData();
                       $perfil->FK_BAQ_SUBMENUS = $valor;
                       $perfil->FK_BAQ_PERFILES = $objperfil->idperfil;
                       $perfil->borrado = 0;
                       $perfil->fecha_creacion = date('Y-m-d H:m:i');
                       $perfil->usuario_creacion = 1;
                       $u = $perfil->add();

                    } 
               endforeach;

               $list = implode(",",$objperfil->opcionmenu);
               
               $mperfilnotin = PerfilSubmenuData::getPerfilSubmenuNotIn($objperfil->idperfil,$list); 
               foreach ($mperfilnotin as $row_submenu) :

                  if($row_submenu!=''){

                       $perfil = new PerfilSubmenuData();
                       $perfil->FK_BAQ_SUBMENUS=$row_submenu->idsubmenu;
                       $perfil->FK_BAQ_PERFILES=$objperfil->idperfil;
                       $perfil->borrado = 1;
                       $perfil->fecha_eliminacion = date('Y-m-d H:m:i');
                       $perfil->usuario_eliminacion = 1;
                       $u = $perfil->delete();

                  }

               endforeach;


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
                   "menu" => $perfil
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                               
               

            
                
              echo json_encode(array("exito" => "guardado")); 
        
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
  }



  function eliminar_perfil($objperfil) {  

    
         if($objperfil!=null){

                
               $perfil = new PerfilData();
               $perfil->PK_baq_perfiles = $objperfil->idperfil;
               $perfil->borrado = 1;
               $perfil->fecha_eliminacion = date('Y-m-d H:m:i');
               $perfil->usuario_eliminacion = 1;
          
          
               $u = $perfil->delete();
               
               
               
               
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
                   "menu" => $perfil
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                               
               

            
                
              echo json_encode(array("exito" => "eliminado")); 
        
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
  }


  ?>