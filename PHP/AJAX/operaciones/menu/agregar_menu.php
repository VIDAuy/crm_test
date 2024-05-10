<?php
include_once '../../../configuraciones.php';

$select_area = $_REQUEST['select_area'];
$select_item = $_REQUEST['select_item'];


if ($select_area == "" || $select_item == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($select_area, $select_item);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("El área ya tiene este item asignado");

    if ($id != "" && $activo == 0) {
        $reactivar_contenido = reactivar_contenido(TABLA_MENU_POR_AREA, $id);
        if ($reactivar_contenido == false) devolver_error("Ocurrieron errores al reactivar el item");
    }
} else {

    $agregar_menu = agregar_menu($select_area, $select_item);
    if ($agregar_menu == false) devolver_error("Ocurrieron errores al registrar el menú");
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function comprobar_existencia($select_area, $select_item)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENU_POR_AREA;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_usuario = '$select_area' AND id_item = '$select_item' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_menu.php", $error);
        $consulta = false;
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
