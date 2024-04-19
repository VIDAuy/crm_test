<?php
include_once '../../../configuraciones.php';

$select_area = $_REQUEST['select_area'];
$select_item = $_REQUEST['select_item'];


if ($select_area == "" || $select_item == "") devolver_error(ERROR_GENERAL);


$verificar_menu_existente = verificar_menu($select_area, $select_item);
if ($verificar_menu_existente == false) devolver_error("Ocurrieron errores al verificar el menu");


if (mysqli_num_rows($verificar_menu_existente) > 0) devolver_error("El área ya tiene el item asignado");


$agregar_menu = agregar_menu($select_area, $select_item);
if ($agregar_menu == false) devolver_error("Ocurrieron errores al registrar el menú");



$response['error'] = false;
$response['mensaje'] = "Se ha registrado con éxito";
echo json_encode($response);




function verificar_menu($select_area, $select_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_AREA;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_usuario = '$select_area' AND id_item = '$select_item' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_menu.php", $error);
    }

    return $consulta;
}

function agregar_menu($select_area, $select_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_AREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_usuario, id_item) VALUES ('$select_area', '$select_item')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_menu.php", $error);
    }

    return $consulta;
}
