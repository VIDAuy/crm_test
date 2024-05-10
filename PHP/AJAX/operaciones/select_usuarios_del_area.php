<?php
include_once '../../configuraciones.php';

$id_area = $_REQUEST['id_area'];
$id_usuario = $_REQUEST['id_usuario'];


$consulta_usuarios = obtener_usuarios_del_area($id_area, $id_usuario);

while ($row = mysqli_fetch_assoc($consulta_usuarios)) {
    $row['nombre'] = ucfirst($row['nombre']) . " " . ucfirst($row['apellido']);
    $f[] = $row;
}

$respuesta['datos'] = $f;
echo json_encode($respuesta);



function obtener_usuarios_del_area($id_area, $id_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $where = $id_usuario != "null" ? "id != '$id_usuario' AND" : "";

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_sector = '$id_area' AND $where activo = 1 ORDER BY nombre, apellido ASC";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "select_usuario_del_area.php", $error);
    }

    return $consulta;
}
