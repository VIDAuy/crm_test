<?php
include_once '../../configuraciones.php';

$id_area = $_REQUEST['id_area'];


$consulta_usuarios = obtener_usuarios_del_area($id_area);

while ($row = mysqli_fetch_assoc($consulta_usuarios)) {
    $row['nombre'] = ucfirst($row['nombre']) . " " . ucfirst($row['apellido']);
    $f[] = $row;
}

$respuesta['datos'] = $f;
echo json_encode($respuesta);



function obtener_usuarios_del_area($id_area)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_sector = '$id_area' AND activo = 1 ORDER BY nombre, apellido ASC";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "select_usuario_del_area.php", $error);
    }

    return $consulta;
}
