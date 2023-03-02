<header class="header">
    <?php 
        if($_GET['vista']=="admin"){
            echo '<a href="index.php?vista=logout" class="logo">
                <img src="assets/images/logo.png" class="logo-img">
            </a>';
        }else{
            echo '<a href="index.php?vista=home" class="logo">
                <img src="assets/images/logo.png" class="logo-img">
            </a>';
        }
    ?>
    <nav class="nav">
        <a href="index.php?vista=home" class="nav-link">Inicio</a>
        <a href="#" class="nav-link">Productos</a>
        <a href="#" class="nav-link">Nosotros</a>
        <a href="#" class="nav-link">Tiendas</a>
    </nav>
    <?php
        if($_GET['vista']!="home"){
            echo '<a href="index.php?vista=logout" class="btn-admin">Cerrar Sesión</a>';
        }else{
            echo '<a href="index.php?vista=login" class="btn-admin">Admin</a>';
        }
    ?>
</header>