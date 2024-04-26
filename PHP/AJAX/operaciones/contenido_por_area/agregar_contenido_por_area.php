<?php
include_once '../../../configuraciones.php';

$id_usuario = $_REQUEST['id_usuario'];
$id_contenido = $_REQUEST['id_contenido'];


if ($id_usuario == "" || $id_contenido == "") devolver_error(ERROR_GENERAL);


$registrar_contenido_por_area = registrar_contenido_por_area($id_usuario, $id_contenido);
if ($registrar_contenido_por_area == false) devolver_error("Ocurrieron errores al registrar el contenido por área");



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function registrar_contenido_por_area($id_usuario, $id_contenido)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM_POR_AREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_usuario, id_contenido_crm) VALUES ('$id_usuario', '$id_contenido')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido_por_area.php", $error);
        $consulta = false;
    }

    return $consulta;
}
