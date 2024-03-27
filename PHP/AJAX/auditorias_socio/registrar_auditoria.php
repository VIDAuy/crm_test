<?php
include '../configuraciones.php';

$cedula          = $_REQUEST['cedula'];
$descripcion     = $_REQUEST['descripcion'];
$fecha_auditoria = $_REQUEST['fecha_auditoria'];
$usuario         = $_SESSION['usuario'];


if ($cedula == "" || $descripcion == "" || $fecha_auditoria == "" || $usuario == "") {
    $response['error'] = true;
    $response['mensaje'] = ERROR_GENERAL;
    die(json_encode($response));
}


$verificar_existencia_auditoria = comprobar_auditoria($cedula);

if ($verificar_existencia_auditoria === false) {
    $response['error'] = true;
    $response['mensaje'] = "El socio ya tiene una auditoría registrada";
    die(json_encode($response));
}


$insert_auditoria = registrar_auditoria($cedula, $descripcion, $fecha_auditoria, $usuario);

if ($insert_auditoria === false) {
    $response['error'] = true;
    $response['mensaje'] = ERROR_AL_REGISTRAR;
    die(json_encode($response));
}



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;


echo json_encode($response);




function comprobar_auditoria($cedula)
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    $sql = "SELECT * FROM {$tabla} WHERE cedula = '$cedula' AND activo = 1";
    $consulta = mysqli_query($conexion, $sql);

    $resultado = mysqli_num_rows($consulta) > 0 ? false : true;

    return $resultado;
}

function registrar_auditoria($cedula, $descripcion, $fecha_auditoria, $usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    $sql = "INSERT INTO {$tabla} (cedula, descripcion, fecha, fecha_registro, usuario_registro) VALUES ('$cedula', '$descripcion', '$fecha_auditoria', NOW(), '$usuario')";
    $consulta = mysqli_query($conexion, $sql);

    return $consulta;
}
