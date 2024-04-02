<?php
include_once '../../configuraciones.php';

$cedula = $_REQUEST['cedula'];


if ($cedula == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$comprobacion = comprobar_auditorias($cedula);

if ($comprobacion === false) {
    $response['error'] = 222;
    $response['mensaje'] = ERROR_GENERAL_2;
    die(json_encode($response));
}

if (mysqli_num_rows($comprobacion) <= 0) {
    $response['error'] = true;
    $response['mensaje'] = "El usuario no tiene auditorias registradas";
    die(json_encode($response));
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;


echo json_encode($response);




function comprobar_auditorias($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "comprobar_auditorias.php", $error);
        return false;
    }
}
