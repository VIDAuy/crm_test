<?php
include_once '../../configuraciones.php';


$id_registro = $_REQUEST['id_registro'];
$usuario = $_REQUEST['usuario'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


if ($id_registro == "" || $usuario == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$asignar_usuario = asignar_alerta($id_registro, $usuario, $id_sub_usuario);

if ($asignar_usuario === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al intentar asignar la alerta";
    die(json_encode($response));
}



$response['error'] = false;
$response['mensaje'] = "Se ha asignado la alerta con éxito!";
echo json_encode($response);




function asignar_alerta($id_registro, $usuario_asignado, $usuario_asignador)
{
    $conexion = connection(DB);
    $tabla = TABLA_ALERTAS;

    $sql = "UPDATE {$tabla} SET usuario_alertado = '{$usuario_asignado}', usuario_asignador = '{$usuario_asignador}' WHERE id = '{$id_registro}' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
