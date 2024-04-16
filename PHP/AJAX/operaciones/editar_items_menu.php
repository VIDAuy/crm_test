<?php
include_once '../../configuraciones.php';

$id = $_REQUEST['id'];
$icon_svg = $_REQUEST['icon_svg'];
$ruta_enlace = $_REQUEST['ruta_enlace'];
$funcion = $_REQUEST['funcion'];
$nombre = $_REQUEST['nombre'];
$badge = $_REQUEST['badge'];


if ($id == "" || $icon_svg == "" || $nombre == "") devolver_error(ERROR_GENERAL);



$editar_items_menu = editar_items_menu($id, $icon_svg, $ruta_enlace, $funcion, $nombre, $badge);
if ($editar_items_menu == false) devolver_error("Ocurrieron errores al modificar el registro");



$response['error'] = false;
$response['mensaje'] = "Se modifico el registro con éxito";
echo json_encode($response);




function editar_items_menu($id, $icon_svg, $ruta_enlace, $funcion, $nombre, $badge)
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;

    $sql = "UPDATE {$tabla} SET icon_svg = '$icon_svg', ruta_enlace = '$ruta_enlace', funcion = '$funcion', nombre = '$nombre', badge = '$badge' WHERE id = '$id';";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
