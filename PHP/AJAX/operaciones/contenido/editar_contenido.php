<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$referencia = $_REQUEST['referencia'];


if ($id == "" || $nombre == "" || $referencia == "") devolver_error(ERROR_GENERAL);
$nombre = ucfirst($nombre);


$comprobar_existencia = comprobar_existencia($nombre, $referencia);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id_existe = $result['id'];

    if ($id != $id_existe) {
        devolver_error("Ya existe un registro con el mismo nombre y referencia");
    } else {
        $editar_contenido = editar_contenido($id, $nombre, $referencia);
        if ($editar_contenido == false) devolver_error("Ocurrieron errores al editar el contenido");
    }
}

$editar_contenido = editar_contenido($id, $nombre, $referencia);
if ($editar_contenido == false) devolver_error("Ocurrieron errores al editar el contenido");



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function comprobar_existencia($nombre, $referencia)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE nombre = '$nombre' AND id_referencia_contenido = '$referencia' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function editar_contenido($id, $nombre, $referencia)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM;

    try {
        $sql = "UPDATE {$tabla} SET nombre = '$nombre', id_referencia_contenido = '$referencia' WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}
