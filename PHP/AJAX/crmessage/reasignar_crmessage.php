<?php
include_once '../../configuraciones.php';

$id = $_REQUEST['id'];
$sub_usuario = $_REQUEST['sub_usuario'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


if ($id == "" || $sub_usuario == "") devolver_error(ERROR_GENERAL);


$reasignar_crmessage = reasignar_crmessage($id, $sub_usuario, $id_sub_usuario);
if ($reasignar_crmessage === false) devolver_error("Ocurrieron errores al reasignar CRMessage");



$response['error'] = false;
$response['mensaje'] = "Se reasigno CRMessage con éxito";
echo json_encode($response);




function reasignar_crmessage($id, $sub_usuario, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;

    try {
        $sql = "UPDATE {$tabla} SET usuario_consultado = '$sub_usuario', usuario_reasignador = '$id_sub_usuario' WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "reasignar_crmessage.php", $error);
        $consulta = false;
    }

    return $consulta;
}
