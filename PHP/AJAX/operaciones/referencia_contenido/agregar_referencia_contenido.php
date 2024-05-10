<?php
include_once '../../../configuraciones.php';

$nombre = $_REQUEST['nombre'];


if ($nombre == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($nombre);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("La referencia de contenido que ingreso ya existe");

    if ($id != "" && $activo == 0) {
        $reactivar_referencia = reactivar_referencia($id);
        if ($reactivar_referencia == false) devolver_error("Ocurrieron errores al reactivar la referencia de contenido");
    }
} else {

    $registrar_referencia_contenido = registrar_referencia_contenido($nombre);
    if ($registrar_referencia_contenido == false) devolver_error("Ocurrieron errores al registrar la referencia de contenido");
}

$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function comprobar_existencia($nombre)
{
    $conexion = connection(DB);
    $tabla = TABLA_REFERENCIA_CONTENIDO_CRM;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE nombre = '$nombre' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_referencia_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function reactivar_referencia($id)
{
    $conexion = connection(DB);
    $tabla = TABLA_REFERENCIA_CONTENIDO_CRM;


    try {
        $sql = "UPDATE {$tabla} SET activo = 1 WHERE id = '$id'";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_referencia_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}


function registrar_referencia_contenido($nombre)
{
    $conexion = connection(DB);
    $tabla = TABLA_REFERENCIA_CONTENIDO_CRM;


    try {
        $sql = "INSERT INTO {$tabla} (nombre) VALUES ('$nombre')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_referencia_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}
