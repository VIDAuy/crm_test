<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_menu = obtener_menu();

while ($row = mysqli_fetch_assoc($obtener_menu)) {
    $id = $row['id'];
    $id_usuario = ucfirst(obtener_datos_usuario($row['id_usuario'])['usuario']);
    $id_item = obtener_item($row['id_item'])['nombre'];
    $acciones = "<button class='btn btn-sm btn-danger' onclick='eliminar_menu(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id' => $id,
        'area' => $id_usuario,
        'item' => $id_item,
        'acciones' => $acciones,
    ];
}

echo json_encode($tabla);




function obtener_menu()
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_AREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_menu.php", $error);
    }

    return $consulta;
}

function obtener_item($id_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id = '$id_item' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_menu.php", $error);
    }

    $resultado = mysqli_fetch_assoc($consulta);
    return $resultado;
}
