
<?php 
include_once './res/referencias.php';
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="./core/modules/index/view/index/style.css">
<!------ Include the above in your HEAD tag ---------->

<!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <div class="container">


            <div class="row">
                <div class="col-md-6 escudo">
                   <img id="profile-img" class="profile-img-card" src="./core/modules/index/view/images/letraslogo.png" />
                </div>
                <div class="col-md-6">
                    <div class="card card-container">
                        <form id="form_login" class="text-center" role="search" method="post" >
                            <span id="reauth-email" class="reauth-email"></span>
                            <input type="text" id="user" name="user" class="form-control validar" placeholder="Correo electr&oacute;nico" required autofocus>
                            <br>
                            <input type="password" id="password" name="password"  class="form-control validar" placeholder="Contrase&ntilde;a" required>
                            <div id="remember" class="checkbox">
                                <label>
                                <input type="checkbox" value="remember-me"> Recuerdame
                                </label>
                            </div>
                            <button   id="guardar" name="guardar" class="btn btn-lg btn-primary btn-block btn-signin" type="button">Ingresar</button>
                        </form>
                       <!-- <a href="./?view=resetPassword&page=passwordEmail&action=null" class="forgot-password">
                            ¿Olvidaste tu contrase&ntilde;a?
                        </a>-->
                    </div>
                </div>
            </div>
<!--            <p id="profile-name" class="profile-name-card"></p> -->

    </div><!-- /container -->
    <script src="./core/modules/index/view/index/login.js"></script>