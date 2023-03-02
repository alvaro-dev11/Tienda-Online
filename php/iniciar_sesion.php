<?php

    // Almacenando datos
    $usuario=limpiar_cadena($_POST['usuario']);
    $contraseña=limpiar_cadena($_POST['contraseña']);

    // Verificando campos obligatorios
    if($usuario=="" || $contraseña==""){
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    // Iniciando sesion
    $check_user=conexion();
    $check_user=$check_user->query("SELECT * FROM usuarios WHERE usuario='$usuario'");

    if($check_user->rowCount()==1){
        $datos=$check_user->fetch();

        if($datos['usuario']==$usuario && $datos['contraseña']==$contraseña){

            $_SESSION['id']=$datos['id_usuario'];
            $_SESSION['usuario']=$datos['usuario'];
            
            if(headers_sent()){
                echo "<script> window.location.href='index.php?vista=admin'; </script>";
            }else{
                header("location: index.php?vista=admin");
            }
        }else{
            echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o clave incorrectos
            </div>
        ';
        }
    }else{
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o clave incorrectos
            </div>
        ';
    }
    $check_user=null;