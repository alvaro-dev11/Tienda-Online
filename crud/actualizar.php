<?php

    require_once "../php/main.php";

    // Almacenando id
    $id = limpiar_cadena($_POST['producto_id']);

    // Verificando producto
    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT * FROM productos WHERE id_producto='$id'");

    if($check_producto->rowCount()<=0){
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El producto no existe en el sistema
            </div>
        ';
        exit();
    }else{
        $datos=$check_producto->fetch();
    }
    $check_producto=null;

    // Almacenando datos
    $nombre=limpiar_cadena($_POST['nombre_up']);
    $descripcion=limpiar_cadena($_POST['descripcion_up']);
    $precio=limpiar_cadena($_POST['precio_up']);
    $stock=limpiar_cadena($_POST['stock_up']);

    // Verificando campos obligatorios
    if($nombre=="" || $descripcion=="" || $precio=="" || $stock==""){
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    // Actualizando datos
    $actualizar_producto=conexion();
    $actualizar_producto=$actualizar_producto->prepare("UPDATE productos SET nombre=:nombre,descripcion=:descripcion,precio=:precio,stock=:stock WHERE id_producto=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":descripcion"=>$descripcion,
        ":precio"=>$precio,
        ":stock"=>$stock,
        ":id"=>$id
    ];

    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="success">
                <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
                El producto se actualizó con éxito
                <a href="index.php?vista=admin">Aceptar</a>
            </div>
            ';
    }else{
        echo '
            <div class="danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_producto=null;