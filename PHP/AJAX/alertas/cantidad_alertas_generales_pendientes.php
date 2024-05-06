<?php
include_once '../../configuraciones.php';

$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$opcion = $_REQUEST['opcion'];
$cantidad = 0;


$option = $opcion == 1 ? 1 : 3;
$obtener_alertas_area = obtener_todas_alertas_pendientes($option, $id_area, $id_sub_usuario);
if ($obtener_alertas_area === false) devolver_error("Ocurrieron errores al obtener la cantidad de alertas pendientes");
$cantidad = $cantidad + mysqli_num_rows($obtener_alertas_area);



$response['error'] = false;
$response['cantidad'] = $cantidad;
echo json_encode($response);
