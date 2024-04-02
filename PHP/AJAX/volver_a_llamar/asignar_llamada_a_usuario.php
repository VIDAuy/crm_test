<?php
include_once '../../configuraciones.php';


$id_registro = $_REQUEST['id_registro'];
$id_area = $_REQUEST['id_area'];
$id_usuario_asignar = $_REQUEST['id_usuario_asignar'];
$id_usuario_asignador = $_REQUEST['id_usuario_asignador'];
$tipo_operacion = $_REQUEST['tipo_operacion'];



if ($id_registro == "" || $id_area == "" || $id_usuario_asignar == "" || $id_usuario_asignador == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$asignar_usuario = asignar_llamada($id_registro, $id_area, $id_usuario_asignar, $id_usuario_asignador);

if ($asignar_usuario === false) {
    $response['error'] = true;
    $response['mensaje'] = "Ocurrieron errores al intentar asignar la llamada";
    die(json_encode($response));
}


$response['error'] = false;
$response['mensaje'] = "Se ha asignado la llamada con exito";
echo json_encode($response);




function asignar_llamada($id_registro, $id_area, $id_usuario_asignar, $id_usuario_asignador)
{
    $conexion = connection(DB);
    $tabla = TABLA_AGENDA_VOLVER_A_LLAMAR;

    $sql = "UPDATE {$tabla} SET id_sub_usuario = '{$id_usuario_asignar}', id_usuario_asignador = '{$id_usuario_asignador}' WHERE id = '{$id_registro}' AND area = '{$id_area}'";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
