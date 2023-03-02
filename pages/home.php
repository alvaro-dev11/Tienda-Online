<section class="main container">
    <div class="cards-container">
        <?php
        require_once './php/main.php';

        $producto = conexion();
        $producto = $producto->query("SELECT * FROM productos");

        $datos = $producto->fetchAll();

        foreach ($datos as $rows) {
        ?>


            <div class="card">
                <span class="card-title"><?php echo $rows['nombre'] ?></span>
                <div class="img-card">
                    <?php
                    if (is_file("./assets/images/" . $rows['imagen'])) {
                        echo '<img src="./assets/images/' . $rows['imagen'] . '" width="100" height="90">';
                    } else {
                        echo '<img src="./assets/producto.png" width="100" height="90">';
                    }
                    ?>
                </div>
                <p class="description"><?php echo $rows['descripcion'] ?></p>
                <h2 class="precio">S/. <?php echo $rows['precio'] ?></h2>
            </div>



        <?php }
        $producto = null;
        ?>
    </div>
</section>