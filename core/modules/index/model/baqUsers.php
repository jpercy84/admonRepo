<?php

/**
 *baqUsers: Modelo de la tabla BAQ_USERS para el manejo
 *de Usuarios 
 **/

class baqUsers{

    public static function getID($email){
        /* Recieve an email and get the ID of the user with that email*/
        $sqlQuery = "select * from BAQ_LOGINS WHERE email = '" . $email . "';";
        $response = Executor::doit($sqlQuery);
        $id = mysqli_fetch_array($response[0])[1];
        return $id;
    }

    public static function checkEmail($email){
        /* Checks if an email exists in tables */
        $sqlQuery = "select email from BAQ_LOGINS WHERE email = '" . $email . "';";
        return Executor::doit($sqlQuery);
    }

    public static function checkName($id){
        /* Recieve user ID and get its complete name */
        $sqlQuery = "select concat (p_nombre,' ',s_nombre,' ',p_apellido,' ' ,s_apellido) as user from BAQ_USUARIOS WHERE Pk_baq_usuarios = '" . $id . "'";
        $response =  Executor::doit($sqlQuery);
        $name = mysqli_fetch_array($response[0]);
        return $name;

    }

    public static function createUser($p_nombre = "",
     $s_nombre = "", $p_apellido = "", $s_apellido = "",
     $sexo = ""){
         /* Recieve names and last names to create a new user in BAQ_USUARIOS table */
         $date = date("Y-m-d H:m:s");
         $borrado = "0";
         $fecha_creacion = $date;
         $usuario_creacion =  Session::get("ID");
         $sqlQuery = "insert into BAQ_USUARIOS  
         (p_nombre, s_nombre, p_apellido, s_apellido, sexo, borrado,
         fecha_creacion, usuario_creacion)
         value ('" . $p_nombre . "', '" . $s_nombre . "', '" . $p_apellido . "', '" . $s_apellido 
         . "', '" . $sexo . "', '" . $borrado . "', '" . $fecha_creacion . "', '". $usuario_creacion . "');" ;
        return Executor::doit($sqlQuery);
    }

    public static function createLogin($usersFK, $email, $password){
        /* Add user in BAQ_LOGINS TO ALLOW IT TO INGRESS IN THE PLATFORM */
        $sqlQuery = "insert into BAQ_LOGINS
        (FK_BAQ_USUARIOS, email, password_login) VALUES 
        (" . $usersFK . ", '" . $email . "', '" . md5($password) . "');";
        return Executor::doit($sqlQuery);
    }

    public static function createPerfil($usersFK, $idPerfil){
        /* Assign users profile to a new user */
        $sqlQuery = "insert into BAQ_PERFILES_USUARIOS
        (FK_BAQ_PERFILES, FK_BAQ_USUARIOS) VALUES (" . $idPerfil . "," . $usersFK . ");";
        return Executor::doit($sqlQuery);
    }

    public static function deleteUser($email){
        /* Delete an user by assign borrado to 1 and keep if history in tables */
        $id = self::getID($email);
        $date = date("Y-m-d H:m:s");
        $sesID = Session::get("ID");

        $sqlQuery = "update BAQ_USUARIOS set borrado = 1, fecha_eliminacion = '" . $date . 
        "', usuario_eliminacion = " . Session::get("ID") . " WHERE PK_baq_usuarios = " . $id . ";";
        return Executor::doit($sqlQuery);
    }


    public static function getEmailToken($key){
        /* Get token assign to an email when user wants to restore password */
        $sqlQuery = "select email from BAQ_PASSWORD_RESET WHERE token = '" . $key . "';";
        $response = Executor::doit($sqlQuery);
        $email = mysqli_fetch_array($response[0])["email"];
        return $email;
    }

    public static function changePassword($email, $password){
        /* Change password of an user with its email */
        $sqlQuery = "UPDATE `BAQ_LOGINS` SET `password_login`='".$password."' 
        WHERE `email`='".$email."';";
        Executor::doit($sqlQuery);
    }

    public static function deleteToken($email){
        /* Delete toke after password was restored */
        $sqlQuery = "DELETE FROM `BAQ_PASSWORD_RESET` WHERE `email`='".$email."';";
        Executor::doit($sqlQuery);
    }

    public static function getAllUsers(){
        /* Get data from user, name, last name, email and profile */
        $sqlQuery = "SELECT bu.p_nombre AS Nombre, bu.p_apellido AS Apellido,
        bl.email AS Email, bp.nombre AS Perfil
        FROM BAQ_USUARIOS AS bu
        INNER JOIN BAQ_LOGINS AS bl
        ON bu.PK_baq_usuarios = bl.FK_BAQ_USUARIOS
        INNER JOIN BAQ_PERFILES_USUARIOS AS bpu
        ON bu.PK_baq_usuarios = bpu.FK_BAQ_USUARIOS
        INNER JOIN BAQ_PERFILES AS bp
        ON bp.PK_baq_perfiles = bpu.FK_BAQ_PERFILES WHERE bu.borrado = 0;";
        $response = Executor::doit($sqlQuery);
        return Model::many($response[0],new baqUsers());
    }

    public static function getUserInfo($email){
        /* Get all data from user */
        $sqlQuery = "SELECT bl.email AS Email, bp.nombre as Perfil,  bu.p_nombre AS 'Primer nombre',
        bu.s_nombre AS 'Segundo nombre',
        bu.p_apellido AS 'Primer apellido', bu.s_apellido AS 'Segundo apellido', bu.sexo AS Sexo,
        bu.fecha_creacion AS 'Fecha de creación', bu.fecha_actualizacion AS 'Fecha de actualización',
         CASE WHEN bq.fullName IS NOT NULL
        THEN bq.fullName ELSE 'Vacio' END AS 'Usuario creador',
        CASE WHEN be.fullEliminador IS NOT NULL
        THEN be.fullEliminador ELSE 'Vacio' END AS 'Usuario eliminador' 
            FROM BAQ_USUARIOS AS bu
        LEFT JOIN (SELECT PK_baq_usuarios as ID, CONCAT(p_nombre,' ', p_apellido) AS fullName
            FROM BAQ_USUARIOS) AS bq
        ON bu.usuario_creacion = bq.ID
        LEFT JOIN (SELECT PK_baq_usuarios as ID, CONCAT(p_nombre,' ', p_apellido) AS fullEliminador
            FROM BAQ_USUARIOS) AS be
        ON bu.usuario_eliminacion = be.ID
            INNER JOIN BAQ_LOGINS AS bl
        ON bu.PK_baq_usuarios = bl.FK_BAQ_USUARIOS
            INNER JOIN BAQ_PERFILES_USUARIOS AS bpu
        ON bu.PK_baq_usuarios = bpu.FK_BAQ_USUARIOS
            INNER JOIN BAQ_PERFILES AS bp
        ON bp.PK_baq_perfiles = bpu.FK_BAQ_PERFILES
        WHERE bl.email = '" . $email . "';";
        $response = Executor::doit($sqlQuery);
        return $response[0];
    }

    public static function getUpdateInfo($email){
        /* Get data from user */
        $sqlQuery="SELECT bu.p_nombre AS 'Primer nombre', bu.s_nombre AS 'Segundo nombre',
        bu.p_apellido AS 'Primer apellido', bu.s_apellido AS 'Segundo apellido', bu.sexo AS 'Sexo',
        bl.email AS 'Correo electrónico', bp.nombre AS 'Perfil'
        FROM BAQ_USUARIOS AS bu
        INNER JOIN BAQ_LOGINS AS bl
        ON bu.PK_baq_usuarios = bl.FK_BAQ_USUARIOS
        INNER JOIN BAQ_PERFILES_USUARIOS AS bpu
        ON bu.PK_baq_usuarios = bpu.FK_BAQ_USUARIOS
        INNER JOIN BAQ_PERFILES AS bp
        ON bp.PK_baq_perfiles = bpu.FK_BAQ_PERFILES
        WHERE bl.email = '" . $email . "';";
        $response = Executor::doit($sqlQuery);
        return $response[0];
    }

    public static function updateBaqUsers($id, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $sexo){
        /* Update data for user in BAQ_USUARIOS table */
        $date = date("Y-m-d H:m:s");
        $usuario_actualizacion =  Session::get("ID");
        $sqlQuery="UPDATE BAQ_USUARIOS AS bu SET
            bu.p_nombre = '" . $p_nombre . "', bu.s_nombre = '" . $s_nombre . "', bu.p_apellido = '" . $p_apellido . 
            "', bu.s_apellido = '" . $s_apellido . "', bu.sexo = '" . $sexo . "', bu.fecha_actualizacion = '" . $date .
            "', bu.usuario_actualizacion = " . $usuario_actualizacion . " WHERE bu.PK_baq_usuarios = " . $id . ";";
        $response = Executor::doit($sqlQuery);
        return $response; 
    }

    public static function updateBaqLogins($id, $email){
        /* Update user's email from BAQ_LOGINS */
        $sqlQuery = "UPDATE BAQ_LOGINS AS bl SET
        bl.email = '" . $email . "' WHERE bl.FK_BAQ_USUARIOS = " . $id . ";";
        $response = Executor::doit($sqlQuery);
        return $response;
    }

    public static function updateBaqPerfilesUsuarios($id, $perfil){
        /* Update user's profile */
        $sqlQuery = "UPDATE BAQ_PERFILES_USUARIOS AS bp SET
        bp.FK_BAQ_PERFILES = " . $perfil . " WHERE bp.FK_BAQ_USUARIOS = " . $id . ";";
        $response = Executor::doit($sqlQuery);
        return $response; 
    }
    
}
?>