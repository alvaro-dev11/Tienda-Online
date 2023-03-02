<?php

    require_once("./models/vistasModelo.php");

    class vistasControlador extends vistasModelo{
        // controlador obtener plantilla
        public function obtenerPlantillaControlador(){
            return require_once("./views/plantilla.php");
        }

        // controlador obtener vistas
        public function obtenerVistasControlador(){
            if(isset($_GET['views'])){
                $ruta = explode("/", $_GET['views']);
                $respuesta = vistasModelo::mostrarVistaModelo($ruta[0]);
            }else{
                $respuesta = "principal";
            }

            return $respuesta;
        }
    }