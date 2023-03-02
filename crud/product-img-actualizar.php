<?php

    require_once "../php/main.php";

    // Almacenando id de producto
    $product_id=limpiar_cadena($_POST['img_up_id']);

    // Verificando producto en la BD
    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT * FROM productos WHERE id_producto='$product_id'");

    // Verificamos si se encontró una respuesta
    if($check_producto->rowCount()==1){
        // Recorremos el resultado
        $datos=$check_producto->fetch();
    }else{
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen del PRODUCTO que intenta actualizar no existe
            </div>
        ';
    }
    $check_producto=null;

    // Comprobando si se ha seleccionado una imagen
    if($_FILES['producto_foto']['name']="" || $_FILES['producto_foto']['size']==0){
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha seleccionado ninguna imagen o foto
            </div>
        ';
        exit();
    }

    // Directorio de imagenes
    $ruta_images="../assets/images/";

    // Creando directorio de imagenes
    if(!file_exists($ruta_images)){
        if(!mkdir($ruta_images, 0777)){
            echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error al crear el directorio de imagenes
                </div>
            ';
            exit();
        }
    }

    // Cambiando permisos al directorio
    chmod($ruta_images, 0777);

    // Comprobando formato de las imagenes
    if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
        echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen que ha seleccionado es de un formato que no está permitido
                </div>
            ';
        exit();
    }

    // Comprobando que la imagen no supere el peso permitido
    if(($_FILES['producto_foto']['size']/1024) > 3072){
        echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen que ha seleccionado supera el límite de peso permitido
                </div>
            ';
        exit();
    }

    // Extencion de las imagenes
    switch (mime_content_type($_FILES['producto_foto']['tmp_name'])) {
        case 'image/jpeg':
            $image_ext=".jpg";
            break;
        case 'image/png':
            $image_ext=".png";
            break;
    }

    // Nombre de la imagen
    $image_nom=renombrar_fotos($datos['nombre']);

    // Nombre final de la imagen
    $foto=$image_nom.$image_ext;

    // Moviendo imagen al directorio
    if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $ruta_images.$foto)){
        echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
                </div>
            ';
        exit();
    }

    // Eliminando la imagen anterior
    if(is_file($ruta_images.$datos['imagen']) && $datos['imagen']!=$foto){
        chmod($ruta_images.$datos['imagen'], 0777);
        unlink($ruta_images.$datos['imagen']);
    }

    // Actualizando datos
    $actualizar_producto=conexion();
    $actualizar_producto=$actualizar_producto->prepare("UPDATE productos SET imagen=:foto WHERE id_producto=:id");

    $marcadores=[
        ":foto"=>$foto,
        ":id"=>$product_id
    ];

    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="success">
                <strong>¡IMAGEN O FOTO ACTUALIZADA!</strong><br>
                La imagen del producto ha sido actualizada exitosamente, pulse Aceptar para recargar los cambios.
                <a href="index.php?vista=product_img&producto_id_up='.$product_id.'" class="confirm">Aceptar</a>
            </div>
        ';
    }else{
        // Eliminamos la imagen pasada para poder actualizarla nuevamente
        if(is_file($ruta_images.$foto)){
            chmod($ruta_images.$foto, 0777);
            unlink($ruta_images.$foto);
        }
        echo '
            <div class="success">
                <strong>¡IMAGEN O FOTO ACTUALIZADA!</strong><br>
                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_producto=null;