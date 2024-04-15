<?php
include_once '../../configuraciones.php';

$area = $_REQUEST['area'];

$obtener_usuarios = obtener_usuarios_de_area($area);
if ($obtener_usuarios === false) devolver_error("Ocurrieron errores al registrar la consulta");


if (mysqli_num_rows($obtener_usuarios) <= 0) {
    $response['error'] = false;
    $response['estado'] = 222;
    die(json_encode($response));
}

while ($row = mysqli_fetch_assoc($obtener_usuarios)) {
    $row['id']      = strtolower($row['id']);
    $row['usuario'] = ucfirst($row['nombre']) . " " . ucfirst($row['apellido']);
    $array_usuarios[] = $row;
}



$response['error'] = false;
$response['datos'] = $array_usuarios;
echo json_encode($response);




function obtener_usuarios_de_area($area)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_sector = $area AND activo = 1 ORDER BY nombre, apellido DESC";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "verificar_area_con_sub_usuarios.php", $error);
    }

    return $consulta;
}
