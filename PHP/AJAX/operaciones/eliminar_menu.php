<?php
include_once '../../configuraciones.php';

$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);



$eliminar_menu = eliminar_menu($id);
if ($eliminar_menu == false) devolver_error("Ocurrieron errores al eliminar el menú");



$response['error'] = false;
$response['mensaje'] = "Se elimino el menú con éxito";
echo json_encode($response);




function eliminar_menu($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU;

    $sql = "UPDATE {$tabla} SET activo = 0 WHERE id = '$id'";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
