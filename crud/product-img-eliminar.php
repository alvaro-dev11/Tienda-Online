<?php 

    require_once '../php/main.php';

    // Almacenando datos
    $product_id = limpiar_cadena($_POST['img_del_id']);

    // Verificando producto
    // Abriendo conexion a BD y realizando consulta
    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT * FROM productos WHERE id_producto='$product_id'");

    // Validamos que exista un producto en la BD para recorrer las respuesta de la consulta
    if($check_producto->rowCount()==1){
        $datos=$check_producto->fetch();
    }else{
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen del PRODUCTO que intenta eliminar no existe
            </div>
        ';
        exit();
    }
    $check_producto=null;

    // Directorio de imagenes
    $ruta_images="../assets/images/";

    // Cambiando permisos al directorio
    chmod($ruta_images, 0777);

    // Eliminando imagen
    if(is_file($ruta_images.$datos['imagen'])){
        chmod($ruta_images.$datos['imagen'], 0777);

        if(!unlink($ruta_images.$datos['imagen'])){
            echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error al intentar eliminar la imagen del producto, por favor intente nuevamente
                </div>
            ';
            exit();
        }
    }

    // Actualizando datos
    $actualizar_producto=conexion();
    $actualizar_producto=$actualizar_producto->prepare("UPDATE productos SET imagen=:imagen WHERE id_producto=:id");

    $marcadores=[
        ":imagen"=>"",
        ":id"=>$product_id
    ];

    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="success">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                La imagen del producto ha sido eliminada exitosamente, pulse Aceptar para recargar los cambios.
                <a href="index.php?vista=product_img&producto_id_up='.$product_id.'" class="confirm">Aceptar</a>
            </div>
        ';
    }else{
        echo '
            <div class="success">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                Ocurrieron algunos inconvenientes, sin embargo la imagen del producto ha sido eliminada, pulse Aceptar para recargar los cambios.
                <a href="index.php?vista=product_img&producto_id_up='.$product_id.'" class="confirm">Aceptar</a>
            </div>
        ';
    }

    $actualizar_producto=null;