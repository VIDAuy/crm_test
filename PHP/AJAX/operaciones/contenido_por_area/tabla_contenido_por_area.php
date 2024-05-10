<?php
include_once '../../../configuraciones.php';

$tabla["data"] = [];


$obtener_contenido_por_area = obtener_contenido_por_area();

while ($row = mysqli_fetch_assoc($obtener_contenido_por_area)) {
    $id           = $row['id'];
    $id_usuario   = $row['id_usuario'];
    $area         = ucfirst($row['usuario']);
    $id_contenido = $row['id_contenido'];
    $contenido    = $row['nombre'];
    $acciones = "
    <button class='btn btn-sm btn-primary' onclick='editar_contenido_por_area(true, `" . $id . "`, `" . $id_usuario . "`, `" . $area . "`, `" . $id_contenido . "`, `" . $contenido . "`);'>✏</button>
    <button class='btn btn-sm btn-danger' onclick='eliminar_contenido_por_area(`" . $id . "`);'>❌</button>";

    $tabla["data"][] = [
        'id'        => $id,
        'area'      => $area,
        'contenido' => $contenido,
        'acciones'  => $acciones,
    ];
}

echo json_encode($tabla);




function obtener_contenido_por_area()
{
    $conexion = connection(DB);
    $tabla1 = TABLA_CONTENIDO_CRM_POR_AREA;
    $tabla2 = TABLA_CONTENIDO_CRM;
    $tabla3 = TABLA_USUARIOS;

    try {
        $sql = "SELECT 
                ccpa.id,
                u.id AS 'id_usuario',
                u.usuario,
                cc.id AS 'id_contenido',
                cc.nombre
               FROM 
                {$tabla1} ccpa
                INNER JOIN {$tabla2} cc ON ccpa.id_contenido_crm = cc.id
                INNER JOIN {$tabla3} u ON ccpa.id_usuario = u.id
               WHERE 
                ccpa.activo = 1 AND
                cc.activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "tabla_contenido_por_area.php", $error);
    }

    return $consulta;
}
