<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_contenido = obtener_contenido();

while ($row = mysqli_fetch_assoc($obtener_contenido)) {
    $id       = $row['id'];
    $nombre   = $row['nombre'];
    $acciones = "<button class='btn btn-sm btn-danger' onclick='dar_baja_referencia_contenido(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id'         => $id,
        'nombre'     => $nombre,
        'acciones'   => $acciones,
    ];
}

echo json_encode($tabla);




function obtener_contenido()
{
    $conexion = connection(DB);
    $tabla = TABLA_REFERENCIA_CONTENIDO_CRM;

    try {
        $sql = "SELECT id, nombre FROM {$tabla} WHERE activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_referencia_contenido.php", $error);
    }

    return $consulta;
}
