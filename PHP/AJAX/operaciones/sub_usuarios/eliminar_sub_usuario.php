<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);



$eliminar_sub_usuario = eliminar_sub_usuario($id);
if ($eliminar_sub_usuario == false) devolver_error("Ocurrieron errores al eliminar el sub usuario");



$response['error'] = false;
$response['mensaje'] = "Se elimino el sub usuario con éxito";
echo json_encode($response);




function eliminar_sub_usuario($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_SUB_USUARIOS;

    try {
        $sql = "UPDATE {$tabla} SET activo = 0 WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "eliminar_sub_usuario.php", $error);
    }

    return $consulta;
}
