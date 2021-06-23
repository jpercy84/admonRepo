<?php

include_once './res/referencias.php';

?>
<html>

<head>
    <title>warning</title>
    <link rel="stylesheet" type="text/css" href="core/modules/index/view/estilos/colores.css">
    <link rel="stylesheet" type="text/css" href="core/modules/index/view/estilos/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container" id="contenedor" style="background-color:#ef0c0c !important; padding-top:10px; ">
        <center>
        <img src="./modules/index/view/img/warning.png" width="600" height="600">
        <button class="btn btn-warning" style="position:absolute" onclick="atras()">Atras</button>
        </center>
        
    </div>
</body>
</html>
<script>
    function atras(){
        window.location = `../index.php`
    }
</script>