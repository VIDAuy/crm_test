<?php
include_once '../../../configuraciones.php';

$cedula = $_REQUEST['cedula'];
$mensaje = $_REQUEST['mensaje'];
$sector = $_REQUEST['sector'];
$usuario = $_REQUEST['usuario'];


if ($cedula == "" || $mensaje == "" || $sector == "" || $usuario == "") devolver_error(ERROR_GENERAL);


$agregar_etiqueta_socio = agregar_etiqueta_socio($cedula, $mensaje, $sector, $usuario);
if ($agregar_etiqueta_socio === false) devolver_error("Ocurrieron errores al registrar la etiqueta");



$response['error'] = false;
$response['mensaje'] = "Se agrego la etiqueta con éxito!";
echo json_encode($response);




function agregar_etiqueta_socio($cedula, $mensaje, $sector, $usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_ETIQUETA_SOCIO;

    try {
        $sql = "INSERT INTO {$tabla} (cedula, mensaje, id_area, id_sub_usuario, fecha_registro) VALUES ('$cedula', '$mensaje', '$sector', '$usuario', NOW())";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "agregar_etiqueta_socio.php", $error);
        $consulta = false;
    }

    return $consulta;
}
