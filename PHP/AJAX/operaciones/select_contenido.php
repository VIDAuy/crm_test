<?php
include_once '../../configuraciones.php';

$consultar_contenido =
    isset($_REQUEST['id_contenido']) ?
    obtener_contenido($_REQUEST['id_contenido']) :
    obtener_contenido("");

while ($row = mysqli_fetch_assoc($consultar_contenido)) {
    $row['nombre'] = ucfirst($row['nombre']);
    $f[] = $row;
}

$respuesta['datos'] = $f;
echo json_encode($respuesta);



function obtener_contenido($id_contenido)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM;

    $where = $id_contenido != "" ? "id != '$id_contenido' AND" : "";

    try {
        $sql = "SELECT id, nombre FROM {$tabla} WHERE $where activo = 1 ORDER BY nombre ASC";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "select_contenido.php", $error);
    }

    return $consulta;
}
