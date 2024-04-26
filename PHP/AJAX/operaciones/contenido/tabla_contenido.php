<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_contenido = obtener_contenido();

while ($row = mysqli_fetch_assoc($obtener_contenido)) {
    $id       = $row['id'];
    $nombre   = $row['nombre'];
    $div      = $row['div'];
    $acciones = "<button class='btn btn-sm btn-danger' onclick='dar_baja_registro(`" . $id . "`, `contenido/eliminar_contenido.php`, `contenido`);'>❌</button>";

    $tabla["data"][] = [
        'id'       => $id,
        'nombre'   => $nombre,
        'div'      => $div,
        'acciones' => $acciones,
    ];
}

echo json_encode($tabla);




function obtener_contenido()
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_contenido.php", $error);
    }

    return $consulta;
}
