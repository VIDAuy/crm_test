<?php
include_once '../../configuraciones.php';

$cedula = $_REQUEST['cedula'];


if ($cedula == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$comprobacion = comprobar_clering($cedula);

if ($comprobacion === false) {
    $response['error'] = 222;
    $response['mensaje'] = ERROR_GENERAL_2;
    die(json_encode($response));
}

if (mysqli_num_rows($comprobacion) <= 0) {
    $response['error'] = true;
    $response['mensaje'] = "El usuario no esta en clering";
    die(json_encode($response));
}


$response['error'] = false;
$response['mensaje'] = "El socio esta en clering";


echo json_encode($response);




function comprobar_clering($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_REGISTROS_EQUIFAX;

    try {
        $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula' AND activo = 1";
        $consulta = mysqli_query($conexion, $sql);
        return $consulta;
    } catch (\Throwable $error) {
        registrar_errores($sql, "verificar_socio_en_clering.php", $error);
        return false;
    }
}
