<?php
include_once '../../../configuraciones.php';

$id       = $_REQUEST['id'];
$id_area  = $_REQUEST['id_area'];
$nombre   = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$cedula   = $_REQUEST['cedula'];
$gestor   = $_REQUEST['gestor'];


if ($id == "" || $id_area == "" || $nombre == "" || $apellido == "" || $cedula == "" || $gestor == "") devolver_error(ERROR_GENERAL);



$editar_sub_usuario = editar_sub_usuario($id, $id_area, $nombre, $apellido, $cedula, $gestor);
if ($editar_sub_usuario == false) devolver_error("Ocurrieron errores al modificar el registro");



$response['error'] = false;
$response['mensaje'] = "Se modifico el registro con éxito";
echo json_encode($response);




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
