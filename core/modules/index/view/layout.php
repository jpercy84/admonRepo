<?php
//require "vendor/autoload.php";
error_reporting(0);
if (Session::exists("email")) {
    $page      = (isset($_GET['zone'])) ? $_GET['zone'] : "";

    $email = Session::get("email");
    
}

?>
<!DOCTYPE html>
<html>
<head>


  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>APPBAQ60</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
      
  <link href="res/pluginsplantilla/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="res/pluginsplantilla/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

<link href="res/pluginsplantilla/vendors/nprogress/nprogress.css" rel="stylesheet">

<link href="res/pluginsplantilla/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

<link href="res/pluginsplantilla/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

<link href="res/pluginsplantilla/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />

<link href="res/pluginsplantilla/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


<link href="res/pluginsplantilla/build/css/custom.css" rel="stylesheet">
<link href="res/pluginsplantilla/build/css/layout.css" rel="stylesheet">



</head>
  <!-- Font Awesome -->
  
</head>
<body class="nav-md" id="bodyMenu">
<div class="container body" style="height: 100%  !important">
 <?php if(Session::exists("email")): ?>  


<div class="main_container">

</div>

<div class="top_nav">
<div class="nav_menu">
<div class="nav toggle">
<a id="menu_toggle"><i class="fa fa-bars"></i></a>
</div>
<nav class="nav navbar-nav">
<ul class=" navbar-right">
<li class="nav-item dropdown open" style="padding-left: 15px;">
    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
        Opciones
    </a>
    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
       <!-- <a class="dropdown-item" href="javascript:;">Ayuda</a>-->
        <a class="dropdown-item" href="./?action=processlogout"><i class="fa fa-sign-out pull-right"></i> Cerrar sesi&oacute;n</a>
    </div>
</li>

<li>
   <a href="./?view=index&page=widget-default"><img id="navbar_image" src="./core/modules/index/view/images/bannerAlcaldia.png" /></a>
</li>
</ul>
</nav>
</div>
</div>



<?php endif; ?>
    <!-- Main content -->
    


   <?php if(!Session::exists("email")){ ?> 
    <!--<body  style="background-image:url('res/background.svg'); background-repeat:no-repeat; background-size: cover;">-->
    
        <?php } ?> 
      <?php if(Session::exists("email")): 
  
         $home = 'home';  
  
  ?>
    <!-- MENU LATERAL Y OBJECT PARA LOS MODULOS -->
    <div class="container" id="container" style="background-color:white !important; height:100%; width:100% !important " >
        <div  class="row" style="height: 100% !important ; width: 100% !important" >
           
          <div class="col-md-12"  id="contenido" style="height: 100% !important">
            <?php if ($page!=''): ?>
            <object type="text/html" data="<?= $page; ?>" style="background-color:#EFF4F7 "id="framebody" name="framebody" width="100%" height="900px"> </object>  
            <?php  else: ?>
              <object data="./?view=upload&page=nuevo_archivo&action=null" style="background-color:#EFF4F7 " id="framebody" name="framebody" width="100%" height="900px"> </object>  
            <?php endif; ?>
          </div>
        </div>
    </div>
  <?php endif; ?>
  <!-- - - - - - - - - - - - - - - -->
  <?php 
    if(!Session::exists("email")):
      View::load("index","widget-default");
    endif;
  ?>

  <!-- /.content-wrapper -->


 

</div>
</div>
<script src="res/jquery.min.js"></script>
<script src="res/pluginsplantilla/vendors/jquery/dist/jquery.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/fastclick/lib/fastclick.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/nprogress/nprogress.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/Chart.js/dist/Chart.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/gauge.js/dist/gauge.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/iCheck/icheck.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/skycons/skycons.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/Flot/jquery.flot.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/Flot/jquery.flot.pie.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/Flot/jquery.flot.time.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/Flot/jquery.flot.stack.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/Flot/jquery.flot.resize.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/flot.orderbars/js/jquery.flot.orderBars.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/flot-spline/js/jquery.flot.spline.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/flot.curvedlines/curvedLines.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/DateJS/build/date.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/jqvmap/dist/jquery.vmap.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/jqvmap/dist/maps/jquery.vmap.world.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/vendors/moment/min/moment.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="res/pluginsplantilla/vendors/bootstrap-daterangepicker/daterangepicker.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>

<script src="res/pluginsplantilla/build/js/custom.min.js" type="c13a343a3722f9e573adcdf8-text/javascript"></script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="c13a343a3722f9e573adcdf8-|49" defer=""></script>

<script src="./core/modules/index/view/layout.js"></script>
</body>
</html>
