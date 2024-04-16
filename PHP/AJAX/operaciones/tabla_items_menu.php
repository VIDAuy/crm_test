<?php
include_once '../../configuraciones.php';

$tabla["data"] = [];


$obtener_items = obtener_items();

while ($row = mysqli_fetch_assoc($obtener_items)) {
    $id = $row['id'];
    $icon_svg = $row['icon_svg'];
    $ruta_enlace = $row['ruta_enlace'];
    $ruta_enlace = $ruta_enlace != "" ? "<a href='$ruta_enlace' target='_blank'>$ruta_enlace</a>" : "-";
    $funcion = $row['funcion'] != "" ? $row['funcion'] : "-";
    $nombre = $row['nombre'];
    $badge = $row['badge'] != "" ? $row['badge'] : "-";
    $btnEditar = "<button class='btn btn-sm btn-primary' onclick='editar_items_menu(
        true,
        `" . $row['id'] . "`, 
        `" . $row['icon_svg'] . "`, 
        `" . $row['ruta_enlace'] . "`, 
        `" . $row['funcion'] . "`, 
        `" . $row['nombre'] . "`, 
        `" . $row['badge'] . "`
    );'>✏</button>";
    $btnEliminar = "<button class='btn btn-sm btn-danger' onclick='eliminar_items_menu(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id' => $id,
        'icono_svg' => $icon_svg,
        'ruta_enlace' => $ruta_enlace,
        'funcion' => $funcion,
        'nombre' => $nombre,
        'badge' => $badge,
        'acciones' => $btnEditar . " " . $btnEliminar,
    ];
}

echo json_encode($tabla);




function obtener_items()
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;

    $sql = "SELECT * FROM {$tabla} WHERE activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
