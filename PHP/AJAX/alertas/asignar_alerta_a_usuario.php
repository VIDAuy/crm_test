<?php
include_once '../../configuraciones.php';


$id_registro = $_REQUEST['id_registro'];
$id_usuario_asignador = $_REQUEST['id_usuario_asignador'];
$id_usuario_asignar = $_REQUEST['id_usuario_asignar'];
$tipo_operacion = $_REQUEST['tipo_operacion'];


if ($id_registro == "" || $id_usuario_asignador == "" || $id_usuario_asignar == "" || $tipo_operacion == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$asignar_usuario = asignar_alerta($id_registro, $id_usuario_asignador, $id_usuario_asignar);

if ($asignar_usuario === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al intentar asignar la alerta";
    die(json_encode($response));
}


$mensaje = $tipo_operacion == "Asignar" ? "Se ha asignado la alerta con exito" : "Se ha reasignado la alerta con exito";

$response['error'] = false;
$response['mensaje'] = $mensaje;
echo json_encode($response);




function asignar_alerta($id_registro, $id_usuario_asignador, $id_usuario_asignar)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    $sql = "UPDATE {$tabla} SET id_usuario_asignado = '{$id_usuario_asignar}', id_usuario_asignador = '{$id_usuario_asignador}' WHERE id = '{$id_registro}' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
