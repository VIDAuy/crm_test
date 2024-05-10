<?php
include_once '../../../configuraciones.php';

$icon_svg = $_REQUEST['icon_svg'];
$ruta_enlace = $_REQUEST['ruta_enlace'];
$funcion = $_REQUEST['funcion'];
$nombre = $_REQUEST['nombre'];
$badge = $_REQUEST['badge'];


if ($icon_svg == "" || $nombre == "") devolver_error(ERROR_GENERAL);
$nombre = ucfirst($nombre);


$comprobar_existencia = comprobar_existencia($nombre);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("Ya existe un item con este nombre");

    if ($id != "" && $activo == 0) {
        $reactivar_contenido = reactivar_contenido(TABLA_ITEMS_MENU, $id);
        if ($reactivar_contenido == false) devolver_error("Ocurrieron errores al reactivar el item");

        $mensaje = "Se reactivo el registro de nombre '$nombre'";
    }
} else {

    $registrar_items_menu = registrar_items_menu($icon_svg, $ruta_enlace, $funcion, $nombre, $badge);
    if ($registrar_items_menu == false) devolver_error("Ocurrieron errores al registrar el item del menú");

    $mensaje = EXITO_AL_REGISTRAR;
}



$response['error'] = false;
$response['mensaje'] = $mensaje;
echo json_encode($response);




function comprobar_existencia($nombre)
{
    $conexion = connection(DB);
    $tabla = TABLA_ITEMS_MENU;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE nombre = '$nombre' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_items_menu.php", $error);
        $consulta = false;
    }

    return $consulta;
}

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
