<?php
//ob_start(); 
error_reporting(0);
include "./res/referencias.php";

$idperfil  = $_GET["idperfil"];
//$ver_tarea = $_GET["ver_tarea"];
?>
 <script type="text/javascript" > 

</script>  
<section class="content">
 
  <link rel="stylesheet" href="core/modules/index/view/upload/css/upload.css">     

      <!-- Main content -->
      <br>
      <br>
      <section class="content">
        <div class="container-fluid">
          <div class="row">


           <div class="col-md-1">
           </div> 

           <div class="col-md-10">
                <div class="x_panel" style="border: 0px solid #E3E3E3 !important;border-radius: 20px !important;color: #2c2c2c !important;">
                  <div class="x_title">
                   
                    
                  </div>
                  <div class="x_content">
                  
                    <br />
                  <form name="form1" onSubmit="return uploadFile();" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">        

                    <div class="row">
                     <div class="col-md-6">
                         <div class="form-group">
                              
                               <div class="input-group">
                                    <!--<div class="custom-file">
                                       <input type="file" class="custom-file-input" id="file" name="file"  >
                                       <label class="custom-file-label" id="labelnombre" for="InputFile">Seleccionar Archivo</label>
                                    </div>-->
                                    <span class="InputFile">
                                    <input type="file" name="file" id="InputFile">
                                    </span>
                                    <label for="InputFile" id="labelnombre" class="cInputFile">
                                        <span>
                                          Seleccionar Archivo&nbsp;<img width="50" height="40" src="./core/modules/index/view/upload/css/iconocarga.svg" />
                                        </span>
                                    </label>
                               </div>
                          </div>
              
                       </div>
                   </div>

                  


                         <div class="row">
                          <div class="col-md-6">
                            <div id="cargar"></div>&nbsp;
                            <div id="uploadlist"></div> 
                            &nbsp;
                          </div>
                         </div>       

           

                  <div class="row">
                         <div class="col-md-4">
                             <button type="button" id="guardar" onclick="uploadchange();" style="background-color:#3aaa35 "  class="btn btn-round btn-success">Guardar</button>   
                          </div>
                  </div>  

                        
                        

                   


                

                  </form> 

                  </div>
                </div>
            </div> 
            <div class="col-md-1">
            </div>       

          </div>
        </div> 
     </section>   


    <!-- DATOS -->
    <input id="idperfil" type="hidden" value="<?php //echo $idperfil; ?>">
    
    <script src="./core/modules/index/view/upload/gestionar_archivo.js"></script>
   
