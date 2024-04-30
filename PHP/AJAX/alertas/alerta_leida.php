<?php
include_once '../../configuraciones.php';

$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);


$marcar_alerta_leida = marcar_alerta_leida($id, $id_sub_usuario);
if ($marcar_alerta_leida === false) devolver_error("Ocurrieron errores al marcar la alerta como leida");



$response['error'] = false;
$response['mensaje'] = "Se marco la alerta como leida";
echo json_encode($response);
