<?php
include_once '../../../configuraciones.php';

$id       = $_REQUEST['id'];
$id_area  = $_REQUEST['id_area'];
$nombre   = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$cedula   = $_REQUEST['cedula'];
$gestor   = $_REQUEST['gestor'];


if ($id == "" || $id_area == "" || $nombre == "" || $apellido == "" || $cedula == "" || $gestor == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($id_area, $nombre, $apellido, $cedula);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id_existe = $result['id'];

    if ($id != $id_existe) {
        devolver_error("Ya existe un usuario en el área con la misma cédula, nombre y apellido");
    } else {
        $editar_sub_usuario = editar_sub_usuario($id, $id_area, $nombre, $apellido, $cedula, $gestor);
        if ($editar_sub_usuario == false) devolver_error("Ocurrieron errores al modificar el registro");
    }
}

$editar_sub_usuario = editar_sub_usuario($id, $id_area, $nombre, $apellido, $cedula, $gestor);
if ($editar_sub_usuario == false) devolver_error("Ocurrieron errores al modificar el registro");



$response['error'] = false;
$response['mensaje'] = "Se modifico el registro con éxito";
echo json_encode($response);




function comprobar_existencia($id_area, $nombre, $apellido, $cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_sector = '$id_area' AND nombre = '$nombre' AND apellido = '$apellido' AND cedula = '$cedula' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_sub_usuario.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function editar_sub_usuario($id, $id_area, $nombre, $apellido, $cedula, $gestor)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    try {
        $sql = "UPDATE {$tabla} SET id_sector = '$id_area', nombre = '$nombre', apellido = '$apellido', cedula = '$cedula', gestor = '$gestor' WHERE id = '$id';";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_sub_usuario.php", $error);
    }

    return $consulta;
}
