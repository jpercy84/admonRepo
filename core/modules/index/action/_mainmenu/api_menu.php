<?php

use \Firebase\JWT\JWT;
include "core/modules/index/model/MenusData.php";
include "core/modules/index/model/SubMenuData.php";
include "core/modules/index/model/PerfilSubmenuData.php";
  


function listar_menu($campobusqueda,$tipo) {  
      if($tipo != ''){
          if($tipo == "menuuser") $menu = MenusData::getMenuByUser($campobusqueda); //Campo busqueda == email
          if($tipo == "menu") $menu = MenusData::getMenu();    
          if($tipo == "menuperfil") {
            $menu = MenusData::getMenu(); 
            //$menuperfil = MenusData::getMenuByPerfil($campobusqueda); //Campo busqueda == idperfil
          }
          if($menu!=null){
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
                   "menu" => $menu
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
           
            if(count($menu)>0):

               if($tipo == "menuuser"){

                  $tablemenu = '<div class="menu_section">
                     <h3>General</h3>
                     <ul class="nav side-menu">';
                       foreach($menu as $row):
                         $submenu = SubMenuData::getSubMenuByPerfil($row->idmenu,$row->perfil);  
                         $tablemenu .= '<li><a><i class="fa fa-home"></i>'.$row->nombre.'<span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">';
                              foreach($submenu as $rowsubmenu):
                                $tablemenu .= '<li><a href="'.$rowsubmenu->ruta.'" target="framebody" >'.$rowsubmenu->nombre.'</a></li>';
                              endforeach;      
                          $tablemenu .=  '</ul>
                        </li>';
                      endforeach;


                      $tablemenu .= '</ul> 
                  </div>';
                  echo json_encode(array("tablemenu" => $tablemenu));
               }

               if($tipo == "menu" ){
                
                    $tablemenu =  '<div class="list-group">
                            <table class="table">
                            <tr>
                            <th>Id</th>
                            <th>Opci&oacute;n Menu</th>
                            <th>Acceso</th>
                            </tr>';
                            foreach($menu as $row):
                              //$nombreperfil = $row->nombreperfil;
                              $submenu = SubMenuData::getSubMenuByMenu($row->idmenu);  
                              $tablemenu .= '<tr><td colspan="3"><b>'.$row->nombre.'</b></td></tr>';
                              foreach($submenu as $rowsubmenu):
                                $tablemenu .= '<tr><td>'.$rowsubmenu->idsubmenu.'</td>
                                    <td>'.$rowsubmenu->nombre.'</td>
                                    <td><label class="switch"><input type="checkbox" name="optionp[]" id="optionp" value="'.$rowsubmenu->idsubmenu.'"  /><div class="slider round"></div></label></td></tr>';

                              endforeach;                      
                            endforeach;
                    $tablemenu .= '</table>';    
                    echo json_encode(array("tablemenu" => $tablemenu,"nombreperfil" => $nombreperfil));

               
               }

               
                 if($tipo == "menuperfil" ){
                
                    $tablemenu =  '<div class="list-group">
                            <table class="table">
                            <tr>
                            <th>Id</th>
                            <th>Opci&oacute;n Menu</th>
                            <th>Acceso</th>
                            </tr>';
                            foreach($menu as $row):
                            
                              $submenu = SubMenuData::getSubMenuByMenu($row->idmenu);  
                             
                              $tablemenu .= '<tr><td colspan="3"><b>'.$row->nombre.'</b></td></tr>';
                              foreach($submenu as $rowsubmenu):
                              //echo json_encode(array("message" => "Login failed5.".$rowsubmenu->idsubmenu));  
                              $menuperfil = PerfilSubmenuData::getPerfilSubMenu($campobusqueda,$rowsubmenu->idsubmenu); //Campo busqueda == idperfil
                              if($menuperfil->nombreperfil!='')$nombreperfil = $menuperfil->nombreperfil;
                               
                               
                               if($menuperfil->idsubmenu=='')
                               {
                                $tablemenu .= '<tr><td>'.$rowsubmenu->idsubmenu.'</td>
                                    <td>'.$rowsubmenu->nombre.'</td>
                                    <td><label class="switch"><input type="checkbox" name="optionp[]" id="optionp" value="'.$rowsubmenu->idsubmenu.'"  /><div class="slider round"></div></label></td></tr>';
                                }else{
                                 
                                 $tablemenu .= '<tr><td>'.$rowsubmenu->idsubmenu.'</td>
                                    <td>'.$rowsubmenu->nombre.'</td>
                                    <td><label class="switch"><input type="checkbox" name="optionp[]" id="optionp"  value="'.$rowsubmenu->idsubmenu.'" checked  /><div class="slider round"></div></label></td></tr>';

                                }
                              endforeach;                      
                            endforeach;
                    $tablemenu .= '</table>';    
                    echo json_encode(array("tablemenu" => $tablemenu,"nombreperfil" => $nombreperfil));

               
               }

            
             
            endif;
      }else{
      http_response_code(401);
        echo json_encode(array("message" => "Login failed."));

    }
  }else{
    Core::alert("Datos vacios");
    Core::redir("./");
    
  }

 }


  ?>