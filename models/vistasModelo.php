<?php

    class vistasModelo{

        protected static function mostrarVistaModelo($vistas){
            $listaBlanca=["principal", "login", "admin"];
            if(in_array($vistas, $listaBlanca)){
                if(is_file("./views/contenidos/".$vistas.".php")){
                    $contenido="./views/contenidos/".$vistas.".php";
                }else{
                    $contenido="404";
                }
            }elseif($vistas=="index" || $vistas=="principal"){
                $contenido="principal";
            }else{
                $contenido="404";
            }
            return $contenido;
        }
    }