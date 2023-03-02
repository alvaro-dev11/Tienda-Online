<?php

    // Almacenando dato
    $producto_id_del=limpiar_cadena($_GET['producto_id_del']);

    // Verificando producto en la BD
    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT * FROM productos WHERE id_producto='$producto_id_del'");

    if($check_producto->rowCount()==1){

        // Recorrer la consulta y obtener registros
        $datos = $check_producto->fetch();

        // Conectarme a la BD y realizar consulta de eliminación
        $eliminar_producto=conexion();
        $eliminar_producto=$eliminar_producto->prepare("DELETE FROM productos WHERE id_producto=:id");

        // Ejecutar consulta
        $eliminar_producto->execute([":id"=>$producto_id_del]);

        // Si se encontró un registro
        // Eliminarlo de la BD
        if($eliminar_producto->rowCount()==1){
            
            // Eliminar tambíen la imagen del directorio
            if(is_file("./assets/images/".$datos['imagen'])){
                chmod("./assets/images/".$datos['imagen'], 0777);
                unlink("./assets/images/".$datos['imagen']);
            }

            echo '
                <div class="success">
                    <strong>¡PRODUCTO ELIMINADO!</strong><br>
                    Los datos del producto se eliminaron con exito
                    <a href="index.php?vista=admin" class="confirm">Aceptar</a>
                </div>
            ';
        }else{
            echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo eliminar el producto, por favor intente nuevamente
                </div>
            ';
        }
        
        // Cerramos la conexion
        $eliminar_producto=null;
    }else{
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRODUCTO que intenta eliminar no existe
            </div>
        ';
    }
    // Cerramos la conexion
    $check_producto=null;