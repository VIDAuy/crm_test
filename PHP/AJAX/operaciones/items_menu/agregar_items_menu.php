<?php
include_once '../../../configuraciones.php';

$icon_svg = $_REQUEST['icon_svg'];
$ruta_enlace = $_REQUEST['ruta_enlace'];
$funcion = $_REQUEST['funcion'];
$nombre = $_REQUEST['nombre'];
$badge = $_REQUEST['badge'];


if ($icon_svg == "" || $nombre == "") devolver_error(ERROR_GENERAL);



$registrar_items_menu = registrar_items_menu($icon_svg, $ruta_enlace, $funcion, $nombre, $badge);
if ($registrar_items_menu == false) devolver_error("Ocurrieron errores al registrar el item del menú");



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function registrar_items_menu($icon_svg, $ruta_enlace, $funcion, $nombre, $badge)
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;

    try {
        $sql = "INSERT INTO {$tabla} (icon_svg, ruta_enlace, funcion, nombre, badge) VALUES ('$icon_svg', '$ruta_enlace', '$funcion', '$nombre', '$badge')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_items_menu.php", $error);
    }

    return $consulta;
}
