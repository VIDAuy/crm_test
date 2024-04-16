<?php
include_once '../../configuraciones.php';


$obtener_items = obtener_items();
if ($obtener_items == false) devolver_error("Ocurrio un error al obtener los registros");


while ($row = mysqli_fetch_assoc($obtener_items)) {
    $f[] = $row;
}

$respuesta['datos'] = $f;
echo json_encode($respuesta);



function obtener_items()
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;

    $sql = "SELECT id, nombre FROM {$tabla} WHERE activo = 1 ORDER BY id DESC";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
