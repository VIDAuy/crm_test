<?php
include_once '../../../configuraciones.php';

$id_area = $_REQUEST['id_area'];
$id_usuario = $_REQUEST['id_usuario'];
$id_item = $_REQUEST['id_item'];


if ($id_area == "" || $id_usuario == "" || $id_item == "") devolver_error(ERROR_GENERAL);


$verificar_menu_usuario_existente = verificar_menu_usuario($id_area, $id_usuario, $id_item);
if ($verificar_menu_usuario_existente == false) devolver_error("Ocurrieron errores al verificar el menú usuario");
if (mysqli_num_rows($verificar_menu_usuario_existente) > 0) devolver_error("El usuario ya tiene el item asignado por usuario");


$verificar_menu_area_existente = verificar_menu_area($id_area, $id_item);
if ($verificar_menu_area_existente == false) devolver_error("Ocurrieron errores al verificar el menú área");
if (mysqli_num_rows($verificar_menu_area_existente) > 0) devolver_error("El usuario ya tiene el item asignado por área");


$agregar_menu_usuario = agregar_menu_usuario($id_area, $id_usuario, $id_item);
if ($agregar_menu_usuario == false) devolver_error("Ocurrieron errores al registrar el menú al usuario");



$response['error'] = false;
$response['mensaje'] = "Se ha registrado con éxito";
echo json_encode($response);




function verificar_menu_usuario($id_area, $id_usuario, $id_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_USUARIO;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_usuario = '$id_area' AND id_sub_usuario = '$id_usuario' AND id_item = '$id_item' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_menu.php", $error);
    }

    return $consulta;
}

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
