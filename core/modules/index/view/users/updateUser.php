<?php 
    include "./res/referencias.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar usuario</title>

    <link rel="stylesheet" href="core/modules/index/view/users/css/updateUser.css">

</head>
<body>
    <div class="infoHead">
        <div class="row">
            <div class="col-md-10 col-sm-12">
                <h1>Actualizaci&oacute;n de Usuario</h1>  
            </div>
            <div class="col-md-2 col-sm-12">
                <button class="btn float-right backBtn btn-lg" onclick="goBack()">Volver</button>
            </div>
        </div>
    </div>
    <!--<section class="info" style="width: ">
    </section>-->
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" id="info">
        </div> 
        <div class="col-md-2"></div>    
    </div>
</body>
<script src="./core/modules/index/view/users/scripts/updateUser.js"></script>
</html>