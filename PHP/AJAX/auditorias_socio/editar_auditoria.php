<?php
include_once '../../configuraciones.php';

$id = $_REQUEST['id'];
$descripcion = $_REQUEST['descripcion'];
$fecha_auditoria = $_REQUEST['fecha_auditoria'];
$id_area = $_SESSION['id'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


if ($id == "" || $descripcion == "" || $fecha_auditoria == "") devolver_error(ERROR_GENERAL);


$editar_auditoria = editar_auditoria($id, $descripcion, $fecha_auditoria, $id_area, $id_sub_usuario);
if ($editar_auditoria === false) devolver_error("Ocurrieron errores al editar la auditoría");



$response['error'] = false;
$response['mensaje'] = "Se edito la auditoría con éxito";
echo json_encode($response);




function editar_auditoria($id, $descripcion, $fecha_auditoria, $id_area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    try {
        $sql = "UPDATE {$tabla} SET descripcion = '$descripcion', fecha = '$fecha_auditoria', area_edito = '$id_area', usuario_edito = '$id_sub_usuario', fecha_edicion = NOW() WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_auditoria.php", $error);
        $consulta = false;
    }

    return $consulta;
}
