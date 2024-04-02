<?php
include_once '../../configuraciones.php';

$id = $_REQUEST['id'];
if ($id == "") devolver_error(ERROR_GENERAL);


$comprobar_registro = comprobar_registro($id);
if (mysqli_num_rows($comprobar_registro) <= 0) devolver_error("No se pudo encontrar el registro");

$eliminar_registro = dar_baja_registro($id);
if ($eliminar_registro == false) devolver_error("Ha ocurrido un error al intentar eliminar el registro");

$eliminar_imagenes = dar_baja_imagenes_registro($id);
if ($eliminar_imagenes == false) devolver_error("Ha ocurrido un error al intentar eliminar los archivos del registro");



$response['error'] = false;
$response['mensaje'] = "Se ha eliminado el registro con éxito";
echo json_encode($response);




function comprobar_registro($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    $sql = "SELECT * FROM {$tabla} WHERE id = '$id' AND eliminado = 0";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function dar_baja_registro($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS;

    $sql = "UPDATE {$tabla} SET eliminado = 1 WHERE id = '$id'";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}

function dar_baja_imagenes_registro($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_IMAGENES_REGISTROS;

    $sql = "UPDATE {$tabla} SET activo = 0 WHERE id_registro = '$id'";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
