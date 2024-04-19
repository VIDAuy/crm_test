<?php
include_once '../../configuraciones.php';

$consulta_usuarios =
    isset($_REQUEST['id_area']) ?
    obtener_areas($_REQUEST['id_area']) :
    obtener_areas("");

while ($row = mysqli_fetch_assoc($consulta_usuarios)) {
    $row['usuario'] = ucfirst($row['usuario']);
    $f[] = $row;
}

$respuesta['datos'] = $f;
echo json_encode($respuesta);



function obtener_areas($id_area)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $where = $id_area != "" ? "id != '$id_area' AND" : "";

    try {
        $sql = "SELECT id, usuario FROM {$tabla} WHERE $where id != 43 ORDER BY usuario ASC";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "select_areas.php", $error);
    }

    return $consulta;
}
