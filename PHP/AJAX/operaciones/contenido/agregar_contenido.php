<?php
include_once '../../../configuraciones.php';

$nombre = $_REQUEST['nombre'];
$referencia = $_REQUEST['referencia'];


if ($nombre == "" || $referencia == "") devolver_error(ERROR_GENERAL);


$comprobar_existencia = comprobar_existencia($nombre, $referencia);
if ($comprobar_existencia == false) devolver_error("Ocurrieron errores al comprobar la existencia del registro");

if (mysqli_num_rows($comprobar_existencia) > 0) {
    $result = mysqli_fetch_assoc($comprobar_existencia);
    $id = $result['id'];
    $activo = $result['activo'];

    if ($id != "" && $activo == 1) devolver_error("El contenido que ingreso ya existe");

    if ($id != "" && $activo == 0) {
        $reactivar_contenido = reactivar_contenido(TABLA_CONTENIDO_CRM, $id);
        if ($reactivar_contenido == false) devolver_error("Ocurrieron errores al reactivar el contenido");
    }
} else {

    $registrar_contenido = registrar_contenido($nombre, $referencia);
    if ($registrar_contenido == false) devolver_error("Ocurrieron errores al registrar el contenido");
}




$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function comprobar_existencia($nombre, $referencia)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM;


    try {
        $sql = "SELECT * FROM {$tabla} WHERE nombre = '$nombre' AND id_referencia_contenido = '$referencia' ORDER BY id DESC LIMIT 1";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}

function registrar_contenido($nombre, $referencia)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM;

    try {
        $sql = "INSERT INTO {$tabla} (nombre, `id_referencia_contenido`) VALUES ('$nombre', '$referencia')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}
