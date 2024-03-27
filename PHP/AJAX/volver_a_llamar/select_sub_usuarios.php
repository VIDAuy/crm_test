<?php
include '../configuraciones.php';


if (!isset($_REQUEST['area'])) {
    $id_sub_usuario = $_REQUEST['id_sub_usuario'];
    $area = obtener_area($id_sub_usuario);

    $id_sub_usuario = !is_numeric($id_sub_usuario) ? obtener_id_sub_usuario($id_sub_usuario) : $id_sub_usuario;

    $array = [];
    $datos = obtener_datos($id_sub_usuario);
} else {
    $area = $_REQUEST['area'];
    $datos = obtener_datos(false);
}


while ($row = mysqli_fetch_assoc($datos)) {
    $row['id'] = strtolower($row['id']);
    $row['nombre'] = ucfirst($row['nombre'] . " " . ucfirst($row['apellido']));
    $f[] = $row;
}


$respuesta = array(
    'datos' => $f
);



echo json_encode($respuesta);




function obtener_datos($id_sub_usuario = false)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;
    global $area;

    if ($id_sub_usuario == false) {
        $sql = "SELECT id, nombre, apellido FROM {$tabla} WHERE id_sector = '$area' ORDER BY id ASC";
    } else {
        $sql = "SELECT id, nombre, apellido FROM {$tabla} WHERE id != '$id_sub_usuario' AND id_sector = '$area' ORDER BY id ASC";
    }

    return mysqli_query($conexion, $sql);
}

function obtener_id_sub_usuario($id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;
    global $area;

    $sql = "SELECT id FROM {$tabla} WHERE nombre = '$id_sub_usuario' AND id_sector = '$area' ORDER BY id ASC";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta)['id'];
}

function obtener_area($id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $sql = "SELECT id_sector FROM {$tabla} WHERE id = '$id_sub_usuario'";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_assoc($consulta)['id_sector'];

    return $resultado;
}
