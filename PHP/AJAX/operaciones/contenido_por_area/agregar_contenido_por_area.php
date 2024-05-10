<?php
include_once '../../../configuraciones.php';

$id_usuario = $_REQUEST['id_usuario'];
$id_contenido = $_REQUEST['id_contenido'];


if ($id_usuario == "" || $id_contenido == "") devolver_error(ERROR_GENERAL);

$comprobar_existencia = comprobar_existencia($id_usuario, $id_contenido);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("El usaurio ya tiene el contenido asignado");

    if ($id != "" && $activo == 0) {
        $reactivar_contenido = reactivar_contenido(TABLA_CONTENIDO_CRM_POR_AREA, $id);
        if ($reactivar_contenido == false) devolver_error("Ocurrieron errores al reactivar el contenido");
    }
} else {

    $registrar_contenido_por_area = registrar_contenido_por_area($id_usuario, $id_contenido);
    if ($registrar_contenido_por_area == false) devolver_error("Ocurrieron errores al registrar el contenido por área");
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function comprobar_existencia($id_usuario, $id_contenido)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM_POR_AREA;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE id_usuario = '$id_usuario' AND id_contenido_crm = '$id_contenido' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido_por_area.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function registrar_contenido_por_area($id_usuario, $id_contenido)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM_POR_AREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_usuario, id_contenido_crm) VALUES ('$id_usuario', '$id_contenido')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido_por_area.php", $error);
        $consulta = false;
    }

    return $consulta;
}
