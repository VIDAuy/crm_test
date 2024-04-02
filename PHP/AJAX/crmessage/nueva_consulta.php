<?php
include_once '../../configuraciones.php';

$area_consulta = $_SESSION['id'];
$area_consultada = $_REQUEST['area_consultada'];
$cedula_socio = $_REQUEST['cedula_socio'];
$consulta = $_REQUEST['consulta'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";



$insert_consulta = registrar_consulta($area_consulta, $area_consultada, $cedula_socio);

if ($insert_consulta === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al registrar la consulta";
    die(json_encode($response));
}


$insert_mensaje = registrar_mensaje($insert_consulta, $consulta, $id_sub_usuario);

if ($insert_mensaje === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al registrar el mensaje";
    die(json_encode($response));
}


$response['error'] = false;
$response['mensaje'] = "Se registro la consulta con éxito";

echo json_encode($response);




function registrar_consulta($area_consulta, $area_consultada, $cedula_socio)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "INSERT INTO {$tabla} (area_consulta, area_consultada, cedula_socio, fecha_consulta) VALUES ('$area_consulta', '$area_consultada', '$cedula_socio', NOW())";
        $consulta = mysqli_query($conexion, $sql);
        $id_insert = mysqli_insert_id($conexion);
        return $consulta != false ? $id_insert : false;
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
        return false;
    }
}

function registrar_mensaje($id_consulta, $mensaje, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_consulta_transarea, mensaje, fecha_registro, id_sub_usuario, visto_consultor, visto_consultado) VALUES ('$id_consulta', '$mensaje', NOW(), '$id_sub_usuario', 1, 0)";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
        return false;
    }


    return $consulta;
}
