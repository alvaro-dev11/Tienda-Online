<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo COMPANY; ?>
    </title>
    <!-- Links -->
    <?php include("./views/inc/Links.php"); ?>
</head>
<body>

    <?php 
        $peticionAjax=false;
        require_once("./controllers/vistasControlador.php");
        $IV=new vistasControlador();
        $vistas=$IV->obtenerVistasControlador();

        if($vistas=="principal" || $vistas=="404"){
            require_once("./views/contenidos/".$vistas.".php");
        }else{
    ?>

    <main>
        <!-- Navbar -->
        <?php include("./views/inc/NavBar.php") ?>
        
        <!-- Contenido principal -->
        <?php include($vistas); ?>

        <!-- Footer -->
    </main>
    <?php
        } 
        // Scripts
    include("./views/inc/Scripts.php");
    ?>
    
</body>
</html>