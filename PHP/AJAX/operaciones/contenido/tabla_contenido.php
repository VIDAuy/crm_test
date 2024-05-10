<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_contenido = obtener_contenido();

while ($row = mysqli_fetch_assoc($obtener_contenido)) {
    $id            = $row['id'];
    $nombre        = $row['nombre'];
    $id_referencia = $row['id_referencia'];
    $referencia    = $row['referencia'];

    $acciones   = "
    <button class='btn btn-sm btn-primary' onclick='editar_contenido(true, `" . $id . "`, `" . $nombre . "`, `" . $id_referencia . "`, `" . $referencia . "`);'>✏</button>
    <button class='btn btn-sm btn-danger' onclick='eliminar_contenido(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id'         => $id,
        'nombre'     => $nombre,
        'referencia' => $referencia,
        'acciones'   => $acciones,
    ];
}

echo json_encode($tabla);




function obtener_contenido()
{
    $conexion = connection(DB);
    $tabla1 = TABLA_CONTENIDO_CRM;
    $tabla2 = TABLA_REFERENCIA_CONTENIDO_CRM;

    try {
        $sql = "SELECT 
                cc.id,
                cc.nombre,
                rcc.id AS 'id_referencia',
                rcc.nombre AS 'referencia'
                FROM 
                {$tabla1} cc
                INNER JOIN {$tabla2} rcc ON rcc.id = cc.id_referencia_contenido
                WHERE 
                cc.activo = 1 AND 
                rcc.activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_contenido.php", $error);
    }

    return $consulta;
}
