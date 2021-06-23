<?php
    include "./res/referencias.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nuevo usuario</title>
    <link rel="stylesheet" href="core/modules/index/view/users/css/newUser.css">
    <script src="./core/modules/index/view/users/scripts/newUser.js"></script>
</head>
<body>
    <div class="content">
        <div class="infoToken col-md-5 offset-md-3 align-middle">
            <form method="post" id="formCreateUser" name="update">
                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        <h1>Nuevo Usuario</h1>  
                    </div>
                </div>

                <input type="hidden" name="action" value="update" />
                <br />

                <label><strong>Email*</strong></label><br/>
                <input class="form-control" type="" name="email" required />
                <br />

                <label><strong>Primer nombre*</strong></label><br/>
                <input class="form-control" type="" name="p_nombre" required />
                <br />

                <label><strong>Segundo nombre</strong></label><br/>
                <input class="form-control" type="" name="s_nombre"/>
                <br />

                <label><strong>Primer apellido*</strong></label><br/>
                <input class="form-control" type="" name="p_apellido" required />
                <br />

                <label><strong>Segundo apellido</strong></label><br/>
                <input class="form-control" type="" name="s_apellido"/>
                <br />

                <label><strong>Contrase&ntilde;a*</strong></label><br/>
                <input class="form-control" type="" name="password"/>
                <br />

                <label><strong>Sexo*</strong></label><br/>
                <select id="sexo" name="sexo" class="form-control" required>
                    <option selected="true" disabled="disabled">Selecciona una opci&oacute;n</option>    
                    <option value="m">Masculino</option>
                    <option value="f">Femenino</option>
                    <option value="o">Otro</option>
                </select>
                <br />

                <label><strong>Perfiles*</strong></label><br/>
                <select id="perfil" name="perfil" class="form-control" required>
                    <option selected="true" disabled="disabled">Selecciona una opci&oacute;n</option>    
                    <option value="1">Administrador</option>
                    <option value="2">General</option>
                </select>
                <br />                

                <button type="submit" class="btn btn-outline-success btn-block" id="successBtn">Agregar Usuario</button>
            </form>
        </div>
    </div>
</body>
</html>