<?php
include_once '../../configuraciones.php';

$id_consulta = $_REQUEST['id_consulta'];
$respuesta = $_REQUEST['respuesta'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


$insert_respuesta = registrar_respuesta($id_consulta, $respuesta, $id_sub_usuario);

if ($insert_respuesta === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurriron errores al registrar la respuesta";
    die(json_encode($response));
}

$update_estado = modificar_estado_consulta($id_consulta);

if ($insert_respuesta === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurriron errores al modificar el estado de la consulta";
    die(json_encode($response));
}

$response['error'] = false;
$response['mensaje'] = "Se registro la respuesta con éxito";


echo json_encode($response);




function registrar_respuesta($id_consulta, $mensaje, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_consulta_transarea, mensaje, fecha_registro, id_sub_usuario, visto_consultor, visto_consultado) VALUES ('$id_consulta', '$mensaje', NOW(), '$id_sub_usuario', 0, 1)";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "responder_consulta.php", $error);
        return false;
    }
}

function modificar_estado_consulta($id_consulta)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "UPDATE {$tabla} SET estado = 2 WHERE id = '$id_consulta'";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "responder_consulta.php", $error);
        return false;
    }
}
