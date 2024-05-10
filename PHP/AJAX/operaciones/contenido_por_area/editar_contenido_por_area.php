<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];
$usuario = $_REQUEST['usuario'];
$contenido = $_REQUEST['contenido'];


if ($id == "" || $usuario == "" || $contenido == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($usuario, $contenido);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id_existe = $result['id'];

    if ($id != $id_existe) {
        devolver_error("Ya existe un registro con el mismo usuario y contenido");
    } else {
        $editar_contenido = editar_contenido($id, $usuario, $contenido);
        if ($editar_contenido == false) devolver_error("Ocurrieron errores al editar el contenido por área");
    }
}

$editar_contenido = editar_contenido($id, $usuario, $contenido);
if ($editar_contenido == false) devolver_error("Ocurrieron errores al editar el contenido por área");



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function comprobar_existencia($usuario, $contenido)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM_POR_AREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_usuario = '$usuario' AND id_contenido_crm = '$contenido' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_contenido_por_area.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function editar_contenido($id, $usuario, $contenido)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM_POR_AREA;

    try {
        $sql = "UPDATE {$tabla} SET id_usuario = '$usuario', id_contenido_crm = '$contenido' WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_contenido_por_area.php", $error);
        $consulta = false;
    }

    return $consulta;
}
