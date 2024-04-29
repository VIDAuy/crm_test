<?php
include_once '../../configuraciones.php';

$cedula          = $_REQUEST['cedula'];
$descripcion     = $_REQUEST['descripcion'];
$fecha_auditoria = $_REQUEST['fecha_auditoria'];
$id_area         = $_SESSION['id'];
$id_sub_usuario  = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";


if ($cedula == "" || $descripcion == "" || $fecha_auditoria == "" || $id_area == "") devolver_error(ERROR_GENERAL);


$insert_auditoria = registrar_auditoria($cedula, $descripcion, $fecha_auditoria, $id_area, $id_sub_usuario);
if ($insert_auditoria === false) devolver_error(ERROR_AL_REGISTRAR);



$response['error'] = false;
$response['mensaje'] = EXITO_AL_REGISTRAR;
echo json_encode($response);




function registrar_auditoria($cedula, $descripcion, $fecha_auditoria, $id_area, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_AUDITORIAS_SOCIO;

    try {
        $sql = "INSERT INTO {$tabla} (cedula, descripcion, fecha, fecha_registro, area_registro, usuario_registro) VALUES ('$cedula', '$descripcion', '$fecha_auditoria', NOW(), '$id_area', '$id_sub_usuario')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "registrar_auditoria.php", $error);
        $consulta = false;
    }

    return $consulta;
}
