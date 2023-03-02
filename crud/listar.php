<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

if (isset($buscador) && $buscador != "") {
    $consulta_datos = "SELECT * FROM productos WHERE ((nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%')) ORDER BY nombre ASC LIMIT $inicio,$registros";

    $consulta_total = "SELECT COUNT(id_producto) FROM productos WHERE ((nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'))";
} else {
    // consulta para mostrar los registros en la tabla en base al paginador
    $consulta_datos = "SELECT * FROM productos ORDER BY nombre ASC LIMIT $inicio,$registros";

    $consulta_total = "SELECT COUNT(id_producto) FROM productos";
}

$conexion = conexion();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn(); // devuelve el numero de la columna

$Npaginas = ceil($total / $registros); // redondea al entero mas próximo

$tabla .= '
            <table class="table-container">
            <thead class="thead">
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th colspan="3">Opciones</th>
            </thead>
            <tbody class="tbody">
        ';

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;
    foreach ($datos as $rows) {
        $tabla .= '
                <tr>
                    <td>' . $contador . '</td>
                    <td>' . $rows['nombre'] . '</td>
                    <td>' . $rows['descripcion'] . '</td>
                    <td>' . $rows['precio'] . '</td>
                    <td>' . $rows['stock'] . '</td>
                    <td>';
                        if(is_file("./assets/images/".$rows['imagen'])){
                            $tabla.='<img src="./assets/images/'.$rows['imagen'].'" class="imagen">';
                        }else{
                            $tabla.='<img src="./assets/producto.png" class="imagen">';
                        }
                    $tabla.='</td>
                    <td class="no-border">
                        <a href="index.php?vista=product_img&producto_id_up=' . $rows['id_producto'] . '"><i class="uil uil-image icon icon-img"></i></a>
                    </td>
                    <td class="no-border">
                        <a href="' . $url . $pagina . '&producto_id_up=' . $rows['id_producto'] . '"><i class="uil uil-edit icon icon-up"></i></a>
                    </td>
                    <td class="no-border">
                        <a href="' . $url . $pagina . '&producto_id_del=' . $rows['id_producto'] . '"><i class="uil uil-trash-alt icon icon-del"></i></a>
                    </td>
                </tr>
            ';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($total >= 1) {
        $tabla .= '
                    <tr>
                        <td colspan="7">
                            <a href="' . $url . '1">
                                Haga click aquí para recargar el listado
                            </a>
                        </td>
                    </tr>
                ';
    } else {
        $tabla .= '
                <tr>
                    <td colspan="7">No hay Registros en el Sistema</td>
                </tr>
            ';
    }
}
$tabla .= '</tbody></table>';
if($total > 0 && $pagina <= $Npaginas){
    $tabla.='
    <p class="has-text">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
}


$conexion=null;
echo $tabla;

if($total >= 1 && $pagina <= $Npaginas){
    echo paginador_tablas($pagina,$Npaginas,$url,7);
}