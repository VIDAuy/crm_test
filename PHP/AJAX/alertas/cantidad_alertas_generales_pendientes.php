<?php
include_once '../../configuraciones.php';

$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$id_funcionalidades = $_REQUEST['id_funcionalidad'];
$cantidad = 0;

if ($id_funcionalidades == "" || !is_array($id_funcionalidades)) devolver_error(ERROR_GENERAL);


foreach ($id_funcionalidades as $id_funcionalidad) {
    $obtener_alertas_area = obtener_todas_alertas_pendientes(1, $id_area, $id_sub_usuario, $id_funcionalidad);
    if ($obtener_alertas_area === false) devolver_error("Ocurrieron errores al obtener la cantidad de alertas por área");
    $cantidad = $cantidad + mysqli_num_rows($obtener_alertas_area);


    if ($id_sub_usuario != "") {
        $obtener_alertas_usuario = obtener_todas_alertas_pendientes(2, $id_area, $id_sub_usuario, $id_funcionalidad);
        if ($obtener_alertas_usuario === false) devolver_error("Ocurrieron errores al obtener la cantidad de alertas por usuario");
        $cantidad = $cantidad + mysqli_num_rows($obtener_alertas_usuario);
    }
}


$response['error'] = false;
$response['cantidad'] = $cantidad;
echo json_encode($response);
