<div class="container">
    <h1 class="title">Actualizar imagen del producto</h1>

    <?php
    // Icluimos el botón para gresar a la página anterior
    include "./inc/Btn_back.php";

    require_once "./php/main.php";

    // Almacenando id de la imagen
    $id = (isset($_GET['producto_id_up'])) ? $_GET['producto_id_up'] : 0;

    // Verificando producto
    // Abriendo conexion a BD y realizando consulta
    $check_producto = conexion();
    $check_producto = $check_producto->query("SELECT * FROM productos WHERE id_producto='$id'");

    // Validamos que exista un producto en la BD para recorrer las respuesta de la consulta
    if ($check_producto->rowCount() > 0) {
        $datos = $check_producto->fetch();
    ?>

        <div class="form-rest"></div>

        <div class="columns form">
            <div class="column-figure">
                <?php
                if (is_file("./assets/images/" . $datos['imagen'])) {
                ?>
                    <figure class="figure">
                        <img src="./assets/images/<?php echo $datos['imagen'] ?>" class="figure-img">
                    </figure>
                    <form action="./crud/product-img-eliminar.php" method="post" class="FormularioAjax" autocomplete="off">
                        <input type="hidden" name="img_del_id" value="<?php echo $datos['id_producto'] ?>">
                        <div class="input-field button button-del-img">
                            <input type="submit" value="Eliminar imagen">
                        </div>
                    </form>
                <?php
                } else {
                ?>
                    <img src="./assets/producto.png">
                <?php } ?>
            </div>
            <div class="column-update">
                <form action="./crud/product-img-actualizar.php" method="post" enctype="multipart/form-data" class="FormularioAjax" autocomplete="off">

                    <h4 class="form-up-title"><?php echo $datos['nombre']; ?></h4>

                    <p>Foto o imagen del producto</p>

                    <input type="hidden" name="img_up_id" value="<?php echo $datos['id_producto'] ?>">

                    <div class="input-field">
                        <label class="file-label">
                            <input type="file" name="producto_foto" accept=".jpg, .png, .jpeg">
                            <span class="file-cta">
                                <span>Imagen</span>
                            </span>
                            <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                        </label>
                    </div>
                    <div class="input-field button button-up-img">
                            <input type="submit" value="Actualizar">
                        </div>
                </form>
            </div>
        </div>
    <?php
    } else {
        include './inc/Error_alert.php';
    }
    $check_producto = null;
    ?>
</div>