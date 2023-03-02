<div class="container">
    <h1 class="title">Administrar Productos</h1>
    <div class="form-rest"></div>


    <?php
    require_once "./php/main.php";

    // Eliminar producto
    if (isset($_GET['producto_id_del'])) {
        require_once "./crud/eliminar.php";
    }

    // Lista de productos
    if (!isset($_GET['page'])) {
        $pagina = 1;
    } else {
        $pagina = (int)$_GET['page'];
        if ($pagina <= 1) {
            $pagina = 1;
        }
    }

    $pagina = limpiar_cadena($pagina);
    $url = "index.php?vista=admin&page=";
    $registros = 15;
    $buscador = "";

    # Paginador y Listado de productos #
    require_once "./crud/listar.php";
    ?>


    <div class="container-form">
        <!-- Formulario para el registro de productos -->
        <div class="form form-save">
            <span class="form-title">Guardar productos</span>
            <form action="./crud/guardar.php" method="POST" class="FormularioAjax" enctype="multipart/form-data" autocomplete="off">
                <div class="input-field">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre del Producto" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="255" required >
                </div>
                <div class="input-field input-field--tarea">
                    <textarea name="descripcion" id="descripcion" rows="10" placeholder="Descripción del producto" required></textarea>
                </div>
                <div class="input-field">
                    <input type="number" name="precio" id="precio" placeholder="S/." pattern="[0-9.]{1,25}" maxlength="25" step="0.01" required >
                </div>
                <div class="input-field">
                    <input type="number" name="stock" id="stock" placeholder="N°" required>
                </div>
                <div class="input-field">
                    <label class="file-label">
                        <input type="file" name="imagen" id="imagen" accept=".jpg, .png, .jpeg">
                        <span class="file-cta">
                            <span>Imagen</span>
                        </span>
                        <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                    </label>
                </div>
                <div class="input-field button">
                    <input type="submit" value="Guardar">
                </div>
            </form>
        </div>
        <div class="form form-update">
            <!-- Formulario para actualizar productos -->

            <?php
            require_once "php/main.php";

            // Almacenando datos
            $id = (isset($_GET['producto_id_up'])) ? $_GET['producto_id_up'] : 0;
            $id = limpiar_cadena($id);

            // Verificando que el producto exista
            $check_producto = conexion();
            $check_producto = $check_producto->query("SELECT * FROM productos WHERE id_producto='$id'");

            if ($check_producto->rowCount() > 0) {
                $datos = $check_producto->fetch();
            ?>

                <div class="form-rest"></div>

                <span class="form-title">Actualizar productos</span>

                <form action="./crud/actualizar.php" method="POST" class="FormularioAjax" enctype="multipart/form-data" autocomplete="off">


                    <!-- Id del producto -->
                    <input type="hidden" name="producto_id" value="<?php echo $datos['id_producto'] ?>" required>

                    <div class="input-field">
                        <input type="text" name="nombre_up" id="nombre_up" placeholder="Nombre del Producto" value="<?php echo $datos['nombre'] ?>" required>
                    </div>

                    <div class="input-field input-field--tarea">
                        <textarea name="descripcion_up" id="descripcion_up" rows="10" placeholder="Descripción del producto" required><?php echo $datos['descripcion'] ?></textarea>
                    </div>

                    <div class="input-field">
                        <input type="number" name="precio_up" id="precio_up" placeholder="S/." value="<?php echo $datos['precio'] ?>" step="0.01" required>
                    </div>

                    <div class="input-field">
                        <input type="number" name="stock_up" id="stock_up" placeholder="N°" value="<?php echo $datos['stock'] ?>" required>
                    </div>


                    <div class="input-field button">
                        <input type="submit" value="Actualizar">
                    </div>
                </form>
            <?php
            }
            $check_producto = null;
            ?>
        </div>
    </div>
</div>