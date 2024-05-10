<?php
include_once '../../../configuraciones.php';

$id = $_REQUEST['id'];
$icon_svg = $_REQUEST['icon_svg'];
$ruta_enlace = $_REQUEST['ruta_enlace'];
$funcion = $_REQUEST['funcion'];
$nombre = $_REQUEST['nombre'];
$badge = $_REQUEST['badge'];


if ($id == "" || $icon_svg == "" || $nombre == "") devolver_error(ERROR_GENERAL);
$nombre = ucfirst($nombre);


$comprobar_existencia = comprobar_existencia($nombre);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id_existe = $result['id'];

    if ($id != $id_existe) {
        devolver_error("Ya existe un item con este nombre");
    } else {
        $editar_items_menu = editar_items_menu($id, $icon_svg, $ruta_enlace, $funcion, $nombre, $badge);
        if ($editar_items_menu == false) devolver_error("Ocurrieron errores al modificar el registro");
    }
}

$editar_items_menu = editar_items_menu($id, $icon_svg, $ruta_enlace, $funcion, $nombre, $badge);
if ($editar_items_menu == false) devolver_error("Ocurrieron errores al modificar el registro");



$response['error'] = false;
$response['mensaje'] = "Se modifico el registro con éxito";
echo json_encode($response);




function comprobar_existencia($nombre)
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE nombre = '$nombre' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_items_menu.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function editar_items_menu($id, $icon_svg, $ruta_enlace, $funcion, $nombre, $badge)
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;

    try {
        $sql = "UPDATE {$tabla} SET icon_svg = '$icon_svg', ruta_enlace = '$ruta_enlace', funcion = '$funcion', nombre = '$nombre', badge = '$badge' WHERE id = '$id';";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "editar_items_menu.php", $error);
    }

    return $consulta;
}
