<?php
include_once '../../../configuraciones.php';

$nombre = $_REQUEST['nombre'];
$div = $_REQUEST['div'];


if ($nombre == "") devolver_error(ERROR_GENERAL);


$registrar_contenido = registrar_contenido($nombre, $div);
if ($registrar_contenido == false) devolver_error("Ocurrieron errores al registrar el contenido");



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);



function registrar_contenido($nombre, $div)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONTENIDO_CRM;


    try {
        $sql = $div == "" ?
            "INSERT INTO {$tabla} (nombre) VALUES ('$nombre')" :
            "INSERT INTO {$tabla} (nombre, `div`) VALUES ('$nombre', '$div')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_contenido.php", $error);
        $consulta = false;
    }

    return $consulta;
}
