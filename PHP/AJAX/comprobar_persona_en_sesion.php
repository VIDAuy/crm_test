<?php
include_once '../configuraciones.php';

$sector = $_REQUEST['sector'];
$cedula = $_REQUEST['cedula'];


$id_sector = obtener_id_sector($sector);

if ($id_sector == "" || $id_sector == false || $id_sector == null) {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$datos_usuario = validar_usuario($id_sector, $cedula);

if ($datos_usuario == "" || $datos_usuario == false || $datos_usuario == null) {
    $response['error'] = true;
    $response['mensaje'] = "La cédula ingresada no pertenece a ninguna persona del sector $sector";
    die(json_encode($response));
}

$id_sub_usuario = $datos_usuario['id'];
$nombre = $datos_usuario['nombre'];
$apellido = $datos_usuario['apellido'];


$_SESSION['id_sub_usuario'] = $id_sub_usuario;
$_SESSION['id_sector'] = $id_sector;
$_SESSION['sector'] = $sector;
$_SESSION['cedula'] = $cedula;
$_SESSION['nombre'] = $nombre;
$_SESSION['apellido'] = $apellido;


$response['error'] = false;
$response['mensaje'] = "Bienvenid@ de vuelta $nombre";
$response['datos'] = [
    "id_sub_usuario" => $id_sub_usuario,
    "id_sector" => $id_sector,
    "sector" => $sector,
    "cedula" => $cedula,
    "nombre" => $nombre,
    "apellido" => $apellido
];

echo json_encode($response);



function obtener_id_sector($sector)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "SELECT id FROM {$tabla} WHERE usuario = '$sector'";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta)['id'];
}

function validar_usuario($id_sector, $cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    $sql = "SELECT id, nombre, apellido FROM {$tabla} WHERE id_sector = '$id_sector' AND cedula = '$cedula' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta);
}
