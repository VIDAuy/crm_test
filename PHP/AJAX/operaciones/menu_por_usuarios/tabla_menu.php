<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_menu = obtener_menu();

while ($row = mysqli_fetch_assoc($obtener_menu)) {
    $id       = $row['id'];
    $area     = ucfirst(obtener_datos_usuario($row['id_usuario'])['usuario']);
    $usuario  = ucfirst(obtener_nombre_sub_usuario($row['id_sub_usuario']));
    $item     = obtener_item($row['id_item'])['nombre'];
    $acciones = "<button class='btn btn-sm btn-danger' onclick='eliminar_menu(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id'       => $id,
        'area'     => $area,
        'usuario'  => $usuario,
        'item'     => $item,
        'acciones' => $acciones,
    ];
}

echo json_encode($tabla);




function obtener_menu()
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_USUARIO;

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
