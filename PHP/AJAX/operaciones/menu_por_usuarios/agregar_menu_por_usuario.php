<?php
include_once '../../../configuraciones.php';

$id_area = $_REQUEST['id_area'];
$id_usuario = $_REQUEST['id_usuario'];
$id_item = $_REQUEST['id_item'];


if ($id_area == "" || $id_usuario == "" || $id_item == "") devolver_error(ERROR_GENERAL);



$verificar_menu_area_existente = verificar_menu_area($id_area, $id_item);
if ($verificar_menu_area_existente == false) devolver_error("Ocurrieron errores al verificar el menú área");
if (mysqli_num_rows($verificar_menu_area_existente) > 0) devolver_error("El usuario ya tiene el item asignado por área");


$comprobar_existencia = comprobar_existencia($id_area, $id_usuario, $id_item);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("El usuario ya tiene este item asignado");

    if ($id != "" && $activo == 0) {
        $reactivar_contenido = reactivar_contenido(TABLA_MENU_POR_USUARIO, $id);
        if ($reactivar_contenido == false) devolver_error("Ocurrieron errores al reactivar el item");
    }
} else {

    $agregar_menu_usuario = agregar_menu_usuario($id_area, $id_usuario, $id_item);
    if ($agregar_menu_usuario == false) devolver_error("Ocurrieron errores al registrar el menú al usuario");
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function verificar_menu_area($id_area, $id_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_AREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_usuario = '$id_area' AND id_item = '$id_item' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_menu.php", $error);
    }

    return $consulta;
}

function comprobar_existencia($select_area, $id_sub_usuario, $select_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_USUARIO;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_usuario = '$select_area' AND id_sub_usuario = '$id_sub_usuario' AND id_item = '$select_item' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_menu.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function agregar_menu_usuario($id_area, $id_usuario, $id_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_USUARIO;

    try {
        $sql = "INSERT INTO {$tabla} (id_usuario, id_sub_usuario, id_item) VALUES ('$id_area', '$id_usuario', '$id_item')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_menu.php", $error);
    }

    return $consulta;
}
