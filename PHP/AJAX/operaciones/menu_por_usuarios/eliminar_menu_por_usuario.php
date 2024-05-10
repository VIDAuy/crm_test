<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);



$eliminar_menu_por_usuario = eliminar_menu_por_usuario($id);
if ($eliminar_menu_por_usuario == false) devolver_error("Ocurrieron errores al eliminar el menú");



$response['error'] = false;
$response['mensaje'] = "Se elimino el menú con éxito";
echo json_encode($response);




function eliminar_menu_por_usuario($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_USUARIO;

    try {
        $sql = "UPDATE {$tabla} SET activo = 0 WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "eliminar_menu_por_usuario.php", $error);
    }

    return $consulta;
}
