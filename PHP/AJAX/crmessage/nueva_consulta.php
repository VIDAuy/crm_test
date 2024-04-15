<?php
include_once '../../configuraciones.php';

$area_consulta = $_SESSION['id'];
$area_consultada = $_REQUEST['area_consultada'];
$cedula_socio = $_REQUEST['cedula_socio'];
$consulta = $_REQUEST['consulta'];
$id_sub_usuario = isset($_SESSION['id_sub_usuario']) ? $_SESSION['id_sub_usuario'] : "";
$id_usuario_consultado = $_REQUEST['id_usuario_consultado'];


if (
    $area_consulta == "" ||
    $area_consultada == "" ||
    $consulta == "" ||
    ($id_usuario_consultado != "" && !is_numeric($id_usuario_consultado))
) devolver_error(ERROR_GENERAL);


$insert_consulta = registrar_consulta($area_consulta, $id_sub_usuario, $area_consultada, $cedula_socio, $id_usuario_consultado);
if ($insert_consulta === false) devolver_error("Ocurrieron errores al registrar la consulta");


$insert_mensaje = registrar_mensaje($insert_consulta, $consulta, $id_sub_usuario);
if ($insert_mensaje === false) devolver_error("Ocurrieron errores al registrar el mensaje");


if ($cedula_socio != "") {
    $registrar_crm = registrar_crm($cedula_socio, $area_consultada, $consulta, $id_sub_usuario);
    if ($registrar_crm === false) devolver_error("Ocurrieron errores al registrar en crm");
}


$response['error'] = false;
$response['mensaje'] = "Se registro la consulta con éxito";

echo json_encode($response);




function registrar_consulta($area_consulta, $id_sub_usuario, $area_consultada, $cedula_socio, $id_usuario_consultado)
{
    $conexion = connection(DB);
    $tabla = TABLA_CONSULTA_TRANSAREA;
    $id_sub_usuario = $id_sub_usuario != "" ? $id_sub_usuario : "";

    try {
        $sql = "INSERT INTO {$tabla} (area_consulta, area_consultada, usuario_consulto, usuario_consultado, cedula_socio, fecha_consulta) VALUES ('$area_consulta', '$area_consultada', $id_sub_usuario, '$id_usuario_consultado', '$cedula_socio', NOW())";
        $consulta = mysqli_query($conexion, $sql);
        $id_insert = mysqli_insert_id($conexion);
        return $consulta != false ? $id_insert : false;
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
        return false;
    }
}

function registrar_mensaje($id_consulta, $mensaje, $id_sub_usuario)
{
    $conexion = connection(DB);
    $tabla = TABLA_MENSAJES_CONSULTA_TRANSAREA;

    try {
        $sql = "INSERT INTO {$tabla} (id_consulta_transarea, mensaje, fecha_registro, id_sub_usuario, visto_consultor, visto_consultado) VALUES ('$id_consulta', '$mensaje', NOW(), '$id_sub_usuario', 1, 0)";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
    }

    return $consulta;
}

function registrar_crm($cedula_socio, $area_consultada, $consulta, $id_sub_usuario)
{
    include_once '../../conexiones/conexion2.php';
    $tabla = TABLA_REGISTROS;
    $sector = $_SESSION['usuario'];
    $socio = es_socio($cedula_socio);
    $baja = esta_en_baja($cedula_socio);
    $datos_padron = obtener_datos_padron_del_socio($cedula_socio);
    $nombre = $datos_padron['nombre'];
    $telefono = $datos_padron['tel'];

    try {
        $sql = "INSERT INTO {$tabla} (cedula, nombre, telefono, fecha_registro, sector, observaciones, envioSector, activo, socio, baja, id_sub_usuario) VALUES ('$cedula_socio', '$nombre', '$telefono', NOW(), '$sector', '$consulta', '$area_consultada', 0, '$socio', '$baja', '$id_sub_usuario')";
        $consulta = mysqli_query($conexion, $sql);
    } catch (\Throwable $error) {
        registrar_errores($sql, "nueva_consulta.php", $error);
    }

    return $consulta;
}
