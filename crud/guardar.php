<?php

    // ALMACENAR, VALIDAR Y GUARDAR DATOS
    require_once "../inc/Session_start.php";

    require_once "../php/main.php";

    // Almacenando datos del formulario
    $nombre=limpiar_cadena($_POST['nombre']);
    $descripcion=limpiar_cadena($_POST['descripcion']);
    $precio=limpiar_cadena($_POST['precio']);
    $stock=limpiar_cadena($_POST['stock']);

    // Verificando datos obligatorios
    if($nombre=="" || $descripcion=="" || $precio=="" || $stock==""){
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    // Directorio de imagenes
    $ruta_images="../assets/images/";

    // Comprobar si se seleccionó una imagen
    if($_FILES['imagen']['name']!="" && $_FILES['imagen']['size']>0){
        
        // Creando directorio
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

        // Verificando el formato de las imagenes
        if(mime_content_type($_FILES['imagen']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['imagen']['tmp_name'])!="image/png"){
            echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen que ha seleccionado es de un formato que no está permitido
                </div>
            ';
            exit();
        }

        // Verificando el tamaño de la imagen
        if(($_FILES['imagen']['size']/1024)>3072){
            echo "La imagen supera el peso permitido (3MB)";
        }

        //Extension de la imagen
        switch (mime_content_type($_FILES['imagen']['tmp_name'])) {
            case 'image/jpeg':
                $img_ext=".jpg";
                break;
            case 'image/png':
                $img_ext=".png";
                break;
        }

        // Cambaindo permisos al directorio
        chmod($ruta_images, 0777);

        // Nombre de la imagen
        $img_nombre=renombrar_fotos($nombre);

        // Nombre final de la imagen
        $foto=$img_nombre.$img_ext;

        // Moviendo imagen al directorio
        if(!move_uploaded_file($_FILES['imagen']['tmp_name'],$ruta_images.$foto)){
            echo '
                <div class="danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
                </div>
            ';
            exit();
        }
    }else{
        $foto = "";
    }

    // Guardando producto
    $guardar_producto=conexion();
    $guardar_producto=$guardar_producto->prepare("INSERT INTO productos(nombre,descripcion,precio,stock,imagen) VALUES(:nombre,:descripcion,:precio,:stock,:imagen)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":descripcion"=>$descripcion,
        ":precio"=>$precio,
        ":stock"=>$stock,
        ":imagen"=>$foto
    ];

    $guardar_producto->execute($marcadores);

    if($guardar_producto->rowCount()==1){
        echo '
            <div class="success">
                <strong>¡PRODUCTO REGISTRADO EXITOSAMENTE!</strong><br>
                Los datos del producto se guardaron con exito
                <a href="index.php?vista=admin" class="confirm">Aceptar</a>
            </div>
        ';
    }else{
        if(is_file($ruta_images.$foto)){
            chmod($ruta_images.$foto, 0777);
            // Eliminar un archivo o imagen del directorio
            unlink($ruta_images.$foto);
        }
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo guardar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_producto=null;
