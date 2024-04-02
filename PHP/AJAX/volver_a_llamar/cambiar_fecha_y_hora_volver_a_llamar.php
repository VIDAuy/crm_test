<?php
include_once '../../configuraciones.php';


$id = $_REQUEST['id'];
$fecha_obtenida = $_REQUEST['fecha'];
$fecha = date("Y-m-d", strtotime($fecha_obtenida));
$hora = date("H:i", strtotime($fecha_obtenida));
$fecha_hora = "$fecha $hora:00";


$fecha_actual = date("Y-m-d H:i:s");


if ($fecha_actual > $fecha_hora) {
    $response['error'] = true;
    $response['mensaje'] = "La fecha y hora no puede ser menor a la fecha de hoy";
    die(json_encode($response));
}


$cambiar_fecha = modificar_fecha_y_hora($id, $fecha_hora);

if ($cambiar_fecha === false) {
    $response['error'] = true;
    $response['mensaje'] = "No se pudo reagendar la llamada";
    die(json_encode($response));
}


$response['error'] = false;
$response['mensaje'] = "Se reagendo la llamada con éxito";



echo json_encode($response);




function modificar_fecha_y_hora($id, $fecha_hora)
{
    $conexion = connection(DB);
    $tabla = TABLA_AGENDA_VOLVER_A_LLAMAR;

    $sql = "UPDATE {$tabla} SET fecha_hora = '$fecha_hora' WHERE id = '$id'";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
