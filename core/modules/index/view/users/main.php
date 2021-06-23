<?php 
    include "core/modules/index/model/baqUsers.php";
    include "./res/referencias.php";
  

  $users = baqUsers::getAllUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="core/modules/index/view/users/css/main.css">



</head>
<body>
    <div class="addUser ml-auto col-3">
            <a href="./?view=users&page=newUser&action=null" class="btn newUser_btn float-right">Agregar Usuario</a>
    </div>
    <?php
        $users = baqUsers::getAllUsers();
        echo "<table class=\"table \" id=\"tableUsers\"> 
            <thead>
                <tr>
                    <th scope=\"col\">EMAIL</th>
                    <th scope=\"col\">NOMBRE</th>
                    <th scope=\"col\">APELLIDO</th>
                    <th scope=\"col\">PERFIL</th>
                    <th scope=\"col\">ELIMINAR</th>
                    <th scope=\"col\">ACTUALIZAR</th>
                    <th scope=\"col\">REVISAR</th>
                </tr>
            </thead>";
        $table = "<tbody>";
        foreach($users as $user):
            $table .= "<tr scope=\"row\">
                    <td>" . $user->Email . "</td>" .
                    "<td>" .$user->Nombre .  "</td>".
                    "<td>" .$user->Apellido .  "</td>".
                    "<td>" .$user->Perfil .  "</td>".
                    "<td>
                        <button type=\"button\" onClick=\"deleteUser('" . $user->Email . "')\"  class=\"btn btn-delete btn-sm\"> Eliminar </button>
                    </td>".
                    "<td><a href=\"./?view=users&page=updateUser&action=null&email=".  $user->Email ."\" class=\"btn btn-update btn-sm\"> Actualizar </a></td>".
                    "<td><a href=\"./?view=users&page=infoUser&action=null&email=".  $user->Email ."\" class=\"btn btn-view btn-sm\"> Revisar </a></td>".
                "</tr>";
        endforeach;
        $table .= "</tbody>";
        echo $table;
        echo "</table>";
    ?>
    
</body>
    <script src="./core/modules/index/view/users/scripts/main.js"></script>
</html>