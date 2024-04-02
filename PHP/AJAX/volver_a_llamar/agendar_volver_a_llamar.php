<?php
include_once '../../configuraciones.php';

$area              = $_REQUEST['area'];
$cedula            = $_REQUEST['cedula'];
$telefono1         = $_REQUEST['telefono1'];
$telefono2         = $_REQUEST['telefono2'];
$telefono3         = $_REQUEST['telefono3'];
$nombre1           = $_REQUEST['nombre1'];
$nombre2           = $_REQUEST['nombre2'];
$nombre3           = $_REQUEST['nombre3'];
$fecha_obtenida    = $_REQUEST['fecha'];
$mensaje           = $_REQUEST['mensaje'];
$id_usuario_agendo = $_REQUEST['id_usuario_agendo'];
$socio             = es_socio($cedula);
$baja              = esta_en_baja($cedula);
$fecha             = date("Y-m-d", strtotime($fecha_obtenida));
$hora              = date("H:i", strtotime($fecha_obtenida));
$fecha_hora        = "$fecha $hora:00";


$fecha_actual = date("Y-m-d H:i:s");

if ($fecha_actual > $fecha_hora) {
    $response['error'] = true;
    $response['mensaje'] = "La fecha y hora no puede ser menor a la fecha de hoy";
    die(json_encode($response));
}


if (is_numeric($telefono1)) {
    $telefono = $telefono1;
} elseif (is_numeric($telefono2)) {
    $telefono = $telefono2;
} elseif (is_numeric($telefono3)) {
    $telefono = $telefono3;
}

if (trim($nombre1) != "" && is_string($nombre1)) {
    $nombre = $nombre1;
} elseif (trim($nombre2) != "" && is_string($nombre2)) {
    $nombre = $nombre2;
} elseif (trim($nombre3) != "" && is_string($nombre3)) {
    $nombre = $nombre3;
}

$area = obtener_id_area($area);

$registrar = registrar_agenda($area, $cedula, $telefono, $nombre, $socio, $baja, $fecha_hora, $mensaje, $id_usuario_agendo);

if ($registrar === false) {
    $response['error'] = true;
    $response['mensaje'] = ERROR_AL_REGISTRAR;
    die(json_encode($response));
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;



die(json_encode($response));




function obtener_id_area($area)
{
    $conexion = connection(DB);
    $tabla = TABLA_USUARIOS;

    $sql = "SELECT id FROM {$tabla} WHERE usuario = '$area'";
    $consulta = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($consulta)['id'];
}

function registrar_agenda($area, $cedula, $telefono, $nombre, $socio, $baja, $fecha_hora, $mensaje, $id_usuario_agendo)
{
    $conexion = connection(DB);
    $tabla = TABLA_AGENDA_VOLVER_A_LLAMAR;

    $sql = "INSERT INTO {$tabla} (area, cedula, telefono, nombre, es_socio, baja, fecha_hora, mensaje, fecha_registro, id_usuario_registrador, id_sub_usuario) VALUES ('$area', '$cedula', '$telefono', '$nombre', '$socio', '$baja', '$fecha_hora', '$mensaje', NOW(), '$id_usuario_agendo', '$id_usuario_agendo')";

    return mysqli_query($conexion, $sql);
}
