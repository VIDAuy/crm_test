<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];
$cedula = $_REQUEST['cedula'];
$mensaje = $_REQUEST['mensaje'];
$id_area = $_REQUEST['sector'];
$id_sub_usuario = $_REQUEST['usuario'];


if ($id == "" || $cedula == "" || $mensaje == "" || $id_area == "" || $id_sub_usuario == "") devolver_error(ERROR_GENERAL);


$editar_etiqueta_socio = editar_etiqueta_socio($id, $cedula, $mensaje, $id_area, $id_sub_usuario);
if ($editar_etiqueta_socio === false) devolver_error("Ocurrieron errores al editar la etiqueta");



$response['error'] = false;
$response['mensaje'] = "Se agrego la etiqueta con éxito!";
echo json_encode($response);




function editar_etiqueta_socio($id, $cedula, $mensaje, $id_area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_ETIQUETA_SOCIO;

    try {
        $sql = "UPDATE {$tabla} SET cedula = '$cedula', mensaje = '$mensaje', id_area = '$id_area', id_sub_usuario = '$id_sub_usuario' WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_etiqueta_socio.php", $error);
        $consulta = false;
    }

    return $consulta;
}
