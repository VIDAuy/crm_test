<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];


if ($id == "") devolver_error(ERROR_GENERAL);



$eliminar_items_menu = eliminar_items_menu($id);
if ($eliminar_items_menu == false) devolver_error("Ocurrieron errores al eliminar el registro");



$response['error'] = false;
$response['mensaje'] = "Se elimino el registro con éxito";
echo json_encode($response);




function eliminar_items_menu($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;

    try {
        $sql = "UPDATE {$tabla} SET activo = 0 WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "eliminar_items_menu.php", $error);
    }

    return $consulta;
}
