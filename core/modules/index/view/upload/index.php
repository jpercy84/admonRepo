
<?php

include_once './res/referencias.php';

?>
<html>
<body>
 <section class="content">
 
     

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
        <div class="row">
          

           <div class="right_col" role="main" style="width: 100%" !important>
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width: 50% !important">
                <h3><small id="title">Administración de Perfiles</small></h3>
              </div>

              <div class="title_right" style="width: 50% !important; text-align: right !important;">
               
                      <h3><small id="title"><a href="./?view=perfiles&page=nuevo_perfil&action=null" target="framebody">NUEVO</a></small></h3>     
                    <!--<input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-secondary" type="button">Go!</button>
                    </span>
                -->
               </div>
            </div>


            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive" id="contenido">
                   
                            <table id="datatable-perfil" class="table table-striped table-bordered" style="width:100%">
                              <thead>
                                <tr>
                                  <th>Consecutivo</th>
                                  <th>Nombre</th>
                                  <th>Acción</th>
                                </tr>
                              </thead>
                              
                              <tbody id="lista" class="buscar"></tbody>
                              
                            </table>
                        </div>
                  </div>
              </div>
            </div>
                </div>
              </div>
     
        </div>
      </div>
     
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
    <!-- /.content -->
 
</section>
</body>
<script src="./core/modules/index/view/perfiles/index.js"></script>
</html>